<?php

namespace Tests\Feature\Livewire;

use App\Livewire\EquationSolver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class EquationSolverTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(EquationSolver::class)
            ->assertStatus(200);
    }

    /** @test */
    public function component_exists_on_the_page()
    {
        $this->get('/')
            ->assertSeeLivewire(EquationSolver::class);
    }

    /** @test */
    public function can_start_over()
    {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', '2+2')
            ->set('equations', ['2+2'])
            ->set('solvedEquations', ['4'])
            ->set('equationSyntaxError', 'error')
            ->set('equationSubmittedError', 'error')
            ->set('calculationError', 'error')
            ->set('buttonsDisabled', true)
            ->call('startOver')
            ->assertSet('newEquationEntry', '')
            ->assertSet('equations', [])
            ->assertSet('solvedEquations', [])
            ->assertSet('equationSyntaxError', null)
            ->assertSet('equationSubmittedError', null)
            ->assertSet('calculationError', null)
            ->assertSet('buttonsDisabled', false);
    }

    /** @test */
    public function can_add_new_equation()
    {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', '2+2')
            ->call('addNewEquation')
            ->assertSee('2+2');
    }

    /** @test */
    public function new_equation_entry_is_required()
    {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', '')
            ->call('addNewEquation')
            ->assertHasErrors(['newEquationEntry' => 'required']);
    }

    /** @test */
    public function new_equation_entry_must_be_less_than_255_characters()
    {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', str_repeat('a', 256))
            ->call('addNewEquation')
            ->assertHasErrors(['newEquationEntry' => 'max']);
    }

    /** @test */
    public function operators_cannot_be_at_end_of_equation() {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', '2+2+')
            ->call('addNewEquation')
            ->assertSet('equationSyntaxError', !null);
    }

    /** @test */
    public function no_double_operators() {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', '2++2')
            ->call('addNewEquation')
            ->assertSet('equationSyntaxError', !null);
    }

    /** @test */
    public function no_multiplication_allowed() {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', '2*2')
            ->call('addNewEquation')
            ->assertSet('equationSyntaxError', !null);
    }

    /** @test */
    public function no_multiplying_variable_with_number_allowed() {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', '2b')
            ->call('addNewEquation')
            ->assertSet('equationSyntaxError', !null);
    }

    /** @test */
    public function no_division_allowed() {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', '2/2')
            ->call('addNewEquation')
            ->assertSet('equationSyntaxError', !null);
    }

    /** @test */
    public function variable_cannot_have_decimal() {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', 'a.2')
            ->call('addNewEquation')
            ->assertSet('equationSyntaxError', !null);
    }

    /** @test */
    public function variable_cannot_be_decimal() {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', '2.b')
            ->call('addNewEquation')
            ->assertSet('equationSyntaxError', !null);
    }

    /** @test */
    public function cannot_have_two_variables_next_to_each_other() {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', 'ab')
            ->call('addNewEquation')
            ->assertSet('equationSyntaxError', !null);
    }

    /** @test */
    public function cannot_have_two_decimals_next_to_each_other() {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', '1..2')
            ->call('addNewEquation')
            ->assertSet('equationSyntaxError', !null);
    }

    /** @test */
    public function cannot_have_decimal_directly_to_left_of_operator() {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', '1.+2')
            ->call('addNewEquation')
            ->assertSet('equationSyntaxError', !null);
    }

    /** @test */
    public function cannot_have_two_commas_next_to_each_other() {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', '1,,2')
            ->call('addNewEquation')
            ->assertSet('equationSyntaxError', !null);
    }

    /** @test */
    public function first_equation_cannot_have_variable() {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', '2+b')
            ->call('addNewEquation')
            ->call('calculateEquations')
            ->assertSet('calculationError', !null);
    }

    /** @test */
    public function calculate_and_add_equation_buttons_disabled_after_clicking() {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', '2+2')
            ->call('addNewEquation')
            ->call('calculateEquations')
            ->assertSet('buttonsDisabled', true);
    }

    /** @test */
    public function can_only_have_maximum_26_equations(){
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27')
            ->call('addNewEquation')
            ->assertSet('equationSyntaxError', !null);
    }

    /** @test */
    public function cannot_solve_equation_if_no_equations(){
        Livewire::test(EquationSolver::class)
            ->call('calculateEquations')
            ->assertSet('calculationError', !null);
    }

    /** @test */
    public function throw_error_if_variable_not_defined_in_previously_solved_equation() {
        Livewire::test(EquationSolver::class)
            ->set('newEquationEntry', 'b+2')
            ->call('addNewEquation')
            ->call('calculateEquations')
            ->assertSet('calculationError', !null);
    }

}
