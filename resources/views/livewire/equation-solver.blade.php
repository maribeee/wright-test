<div class="p-4 flex flex-col gap-10">
    <div>
        <h1 class="uppercase text-bold text-secondary text-4xl">Simple Equation Solver</h1>
        <p class="pt-4">
            Use this tool to calculate up to 26 addition or subtraction equations.
            <br>You can use previous equations as variables in equations further down the line.
            <br>No multiplication, division, or parentheses supported.
        </p>
    </div>

    <div>
        <form wire:submit="addNewEquation" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <label for="equationInput" class="text-sm bg-white absolute -top-3 left-2 px-2">Equations:</label>
                <input
                        class="p-4 border border-stone-300 w-full"
                        type="text"
                        id="equationInput"
                        placeholder="1+1"
                        wire:model="newEquationEntry">
            </div>
            <button
                    class="px-4 py-2 border border-stone-300 rounded-md hover:button-text-hover hover:text-button-hover transition-all disabled:text-button-disabled disabled:bg-button-disabled disabled:cursor-not-allowed max-w-fit font-bold"
                    type="submit"
                    @if($buttonsDisabled) disabled @endif
            >
                Add Equation
            </button>
        </form>

        <div class="mt-4">
            @error('newEquationEntry')
            <div class="bg-error border border-error text-error rounded-md p-4">
                {{ $message }}
            </div>
            @enderror
            @if ($equationSyntaxError)
                <div class="bg-error border border-error text-error rounded-md p-4 flex flex-col gap-3 text-sm">
                    <p>{{ $equationSyntaxError }}</p>
                    <p>If you submitted multiple equations, valid ones listed before the error were added.</p>
                    <p class="font-bold">{{ $equationSubmittedError }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="flex flex-col gap-4 bg-neutral-100 p-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="p-6 flex-1">
                <h2 class="font-bold text-xl mb-4">Equations To Sum</h2>
                @if($equations)
                    <div class="p-6 flex flex-col gap-4">
                        @foreach ($equations as $key => $equation)
                            <div class="bg-neutral-200 p-4">
                                <span class="font-bold">{{ $key }}:</span> {{ $equation }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-neutral-200 p-4">
                        Add equations in the input above to calculate them.
                    </div>
                @endif
            </div>

            @if($solvedEquations)
                <div class="p-6 flex-1">
                    <h2 class="font-bold text-xl mb-4">Solved Equations</h2>
                    <div class="p-6 flex flex-col gap-4">
                        @foreach ($solvedEquations as $key => $solvedEquation)
                            <div class="bg-neutral-200 p-4">
                                <span class="font-bold">{{ $key }}:</span> {{ $solvedEquation }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="flex flex-col sm:flex-row gap-6 justify-between">
            <form wire:submit="calculateEquations">
                <button
                        class="py-2 px-6 font-bold text-button-primary hover:text-button-hover disabled:text-button-disabled bg-button-primary hover:bg-button-hover disabled:bg-button-disabled disabled:cursor-not-allowed text-xl rounded-md transition-all tracking-wider uppercase"
                        type="submit"
                        @if($buttonsDisabled) disabled @endif
                >Calculate
                </button>
            </form>

            <form wire:submit="startOver" class="flex">
                <button class="underline text-sm text-warning self-end font-bold">Reset To Defaults</button>
            </form>
        </div>

        @if ($calculationError)
            <div class="bg-error border border-error text-error rounded-md p-4 flex flex-col gap-3 text-sm">
                <p>{{ $calculationError }}</p>
            </div>
        @endif

    </div>


</div>
