<?php

namespace App\Livewire;

use Illuminate\Support\Arr;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EquationSolver extends Component
{

    public array $equations = array();

    public string $newEquationEntry;

    public array $solvedEquations = array();

    public string $equationSyntaxError;
    public string $equationSubmittedError;
    public string $calculationError;
    public bool $buttonsDisabled = false;

    public function messages()
    {
        return [
            'newEquationEntry.required' => 'Equation cannot be empty',
            'newEquationEntry.max' => 'Equation must be less than 255 characters'
        ];
    }

    /**
     * Resets the page to defaults
     *
     * @return void
     */
    public function startOver(): void
    {
        $this->reset(
            'equations',
            'solvedEquations',
            'newEquationEntry',
            'equationSyntaxError',
            'equationSubmittedError',
            'calculationError',
            'buttonsDisabled',
        );
    }

    /**
     * Adds a new equation to array $equations
     * Linked to the 'Add Equation' button
     *
     * @return void
     */
    public function addNewEquation() {
        $this->reset('equationSyntaxError');

        $validated = $this->validate([
            'newEquationEntry' => [
                'required',
                'max:255'
            ],
        ]);

        // Allows users to enter multiple equations at one time delimited by a comma
        $newEquationArray = preg_split("/,/", $this->newEquationEntry);

        foreach($newEquationArray as $newEquation) {
            $validatedEquation = $this->validateEquation($newEquation);
            if($validatedEquation == null || $validatedEquation == '') break;

            $lastKeyInArray = $this->getLastKey($this->equations);

            if (!$lastKeyInArray) {
                $this->equations['a'] = $validatedEquation;
            } elseif ($lastKeyInArray == 'z'){
                $this->equationSyntaxError = 'You can only have up to 26 equations :(';
            } else {
                $nextKey = $this->getNextLetter($lastKeyInArray);
                $this->equations[$nextKey] = $validatedEquation;
            }
        }

        $this->reset('newEquationEntry');
    }

    /**
     * Calculates sum of equations in public $equations array
     * Linked to the 'Calculate' button
     *
     * @return void
     */
    public function calculateEquations() {
        $this->buttonsDisabled = true;

        if(!$this->equations) {
            $this->calculationError = 'Can\'t solve an equation if there\'s no equation, buddy.';
            return;
        }

        foreach($this->equations as $variable=>$equation){

            // First equation cannot be solved if it has a variable
            if ($this->equationHasVariable($equation) && $variable == 'a') {
                $this->calculationError = 'Variable in equation \'' . $equation . '\' has no definition or is self-referential, cannot solve. Try again with new equations!';
            }
            // If equation has a variable, and it isn't the first equation, parse and solve it
            elseif ($this->equationHasVariable($equation)) {
                $equationWithSolvedVariables = $this->parseEquationVariables($equation);

                if($equationWithSolvedVariables == '') {
                    $this->solvedEquations[$variable] = 'Error';
                    break;
                }

                $this->solvedEquations[$variable] = $this->sumEquation($equationWithSolvedVariables);
            }
            // If equation has no variable, solve it
            else {
                if(!isset($this->solvedEquations[$variable])){
                    $this->solvedEquations[$variable] = $this->sumEquation($equation);
                } else {
                    $this->calculationError = 'Something went wrong, this equation already has a solution!';
                }
            }
        }
    }

    /**
     * Parses array to find variables
     * If variable found in $solvedEquations, replaces with its value
     * Returns re-joined equation
     *
     * @param string $equation
     * @return string
     */
    private function parseEquationVariables(string $equation): string
    {
        $equationArray = preg_split('/([+-])/', $equation, -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach($equationArray as $key=>$value) {
            if (preg_match('/[a-z]/', $value)) {
                $solvedVariable = Arr::get($this->solvedEquations, $value);

                if( $solvedVariable == '' ) {
                    $this->calculationError = 'Something went wrong, could not find a solution for variable \'' . $value . '\'!';
                    return '';
                }

                $equationArray[$key] = $solvedVariable;
            }
        }

        return join('', $equationArray);
    }

    /**
     * Sums an equation
     *
     * @param string $equation
     * @return float|int
     */
    private function sumEquation(string $equation): float|int
    {
        $equationArray = preg_split('/(?=[+-])/', $equation, -1, PREG_SPLIT_NO_EMPTY);
        return array_sum($equationArray);
    }

    /**
     * Returns the last key of an array
     *
     * @param $array
     * @return int|string|null
     */
    private function getLastKey($array): int|string|null
    {
        end($array);
        return key($array);
    }

    /**
     * Get next consecutive letter after provided $letter
     *
     * @param $letter
     * @return string
     */
    private function getNextLetter($letter): string
    {
        return ++$letter;
    }

    /**
     * Returns the validated equation if it passes all checks, otherwise returns null
     *
     * @param string $equation
     * @return string|null
     */
    private function validateEquation(string $equation): ?string
    {
        if ($this->equationIsEmpty($equation)) return null;

        $trimmedEquation = strtolower(preg_replace('/\s+/', '', $equation));

        if (!$this->charactersAreValid($trimmedEquation)) return null;
        if (!$this->variablesCorrectlyPositioned($trimmedEquation)) return null;

        return $trimmedEquation;
    }

    /**
     * Returns true if equation is empty
     *
     * @param string $equation
     * @return bool
     */
    private function equationIsEmpty(string $equation): bool
    {
        if($equation == '' || $equation == null || $equation == ' ') {
            $this->equationSyntaxError = 'Entry is empty or you had two commas next to each other!';
            $this->equationSubmittedError = 'You submitted: ' . $equation;
            return true;
        }
        return false;
    }

    /**
     * If any characters are not digit, letter, + or -, return false
     *
     * If last character is an operator instead of digits or variables, return false
     * If first character is an operator, the assumption is that it's denoting the positive/negative state of the first variable
     *
     * @param string $equation
     * @return bool
     */
    private function charactersAreValid(string $equation): bool
    {
        if( trim($equation, 'a..z0..9.+-') !== '' ) {
            $this->equationSyntaxError = 'Invalid characters, we only support addition and subtraction.';
            $this->equationSubmittedError = 'You submitted: ' . $equation;
            return false;
        }

        $operators = array('+', '-');
        if( in_array(substr($equation, -1), $operators) ) {
            $this->equationSyntaxError = 'Last character must be a number or variable.';
            $this->equationSubmittedError = 'You submitted: ' . $equation;
            return false;
        }

        return true;
    }

    /**
     * Returns false if variable is next to a number (multiplication)
     * Returns false if two variables next to each other
     * Returns false if two operators next to each other
     *
     * @param string $equation
     * @return bool
     */
    private function variablesCorrectlyPositioned(string $equation): bool
    {
        if( preg_match('/\d[a-z]|[a-z]\.|\.[a-z]|[a-z]\d|[a-z][a-z]|[+-][+-]|\.$|\.[+-]|\.\./',  $equation) ) {
            $this->equationSyntaxError = 'Letter variable cannot be directly preceded or followed by a number. Two letter variables or two operators also cannot be directly next to each other. Variable cannot have or be a decimal. Decimal cannot be followed by nothing.';
            $this->equationSubmittedError = 'You submitted: ' . $equation;
            return false;
        }

        return true;
    }

    /**
     * Return true if equation has a letter variable
     *
     * @param string $equation
     * @return bool
     */
    private function equationHasVariable(string $equation): bool
    {
        return preg_match('/[a-z]/', $equation);
    }


    /**
     * Render the livewire component
     */
    #[Title('Simple Equation Solver')]
    public function render()
    {
        return view('livewire.equation-solver');
    }

}
