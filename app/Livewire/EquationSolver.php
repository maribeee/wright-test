<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;


class EquationSolver extends Component
{
    public array $equations = array(
        "a" => "1+2",
        "b" => "a +4 "
    );

    public string $newEquationEntry;

    public bool $buttonsDisabled = false;

    public string $equationSyntaxError;
    public string $equationSubmittedError;


    public function messages()
    {
        return [
            'newEquationEntry.required' => 'Equation cannot be empty',
            'newEquationEntry.max' => 'Equation must be less than 255 characters',
            'newEquationEntry.string' => 'Equation must be a string',
        ];
    }

    public function addNewEquation() {
        $this->reset('equationSyntaxError');

        $validated = $this->validate([
            'newEquationEntry' => [
                'required',
                'max:255',
                'string'
            ],
        ]);

        // Allows users to enter multiple equations at one time delimited by a comma
        $newEquationArray = preg_split("/,/", $this->newEquationEntry);

        foreach($newEquationArray as $newEquation) {
            $validatedEquation = $this->validateEquation($newEquation);
            if($validatedEquation == null || $validatedEquation == '') break;

            dd($validatedEquation);

        }

        $this->reset('newEquationEntry');
    }

    private function validateEquation(string $equation): ?string
    {
        if ($this->equationIsEmpty($equation)) return null;

        $trimmedEquation = strtolower(preg_replace('/\s+/', '', $equation));

        if (!$this->charactersAreValid($trimmedEquation)) return null;
        if (!$this->variablesCorrectlyPositioned($trimmedEquation)) return null;

        return $trimmedEquation;
    }

    private function equationIsEmpty(string $equation): bool
    {
        if($equation == '' || $equation == null || $equation == ' ') {
            $this->equationSyntaxError = 'Entry is empty or you had two commas next to each other!';
            $this->equationSubmittedError = 'You submitted: ' . $equation;
            return true;
        }
        return false;
    }

    private function charactersAreValid(string $equation): bool
    {
        if( trim($equation, 'a..z0..9+-') !== '' ) {
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

    private function variablesCorrectlyPositioned(string $equation): bool
    {
        if( preg_match('/\d[a-z]|[a-z]\.|\.[a-z]|[a-z]\d|[a-z][a-z]|[+-][+-]/',  $equation) ) {
            $this->equationSyntaxError = 'Letter variable cannot be directly preceded or followed by a number. Two letter variables or two operators also cannot be directly next to each other';
            $this->equationSubmittedError = 'You submitted: ' . $equation;
            return false;
        }

        return true;
    }

    #[Title('Simple Equation Solver')]
    public function render()
    {
        return view('livewire.equation-solver');
    }
}
