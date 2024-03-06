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

    public function addNewEquation() {
        dump('add new eq');
    }




    #[Title('Simple Equation Solver')]
    public function render()
    {
        return view('livewire.equation-solver');
    }
}
