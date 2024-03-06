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
            // validate equation syntax
            dump($newEquation);
        }

        $this->reset('newEquationEntry');
    }




    #[Title('Simple Equation Solver')]
    public function render()
    {
        return view('livewire.equation-solver');
    }
}
