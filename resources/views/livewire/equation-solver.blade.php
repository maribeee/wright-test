<div class="p-4 flex flex-col gap-10">

    <div>
        <h1 class="uppercase text-bold text-secondary text-4xl">Simple Equation Summer</h1>
        <p class="pt-4">
            Use this tool to calculate up to 26 addition or subtraction equations.
            <br/>You can use previous equations as variables in equations further down the line.
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
                    @foreach ($equations as $key => $equation)
                        <div>
                            <span class="font-bold">{{ $key }}:</span> {{ $equation }}
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>



</div>
