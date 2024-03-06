<div class="p-4 flex flex-col gap-10">

    <h1 class="uppercase text-bold text-secondary text-4xl">Simple Equation Summer</h1>

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
            </div>
        @endif
    </div>

    {{ $newEquationEntry }}

</div>
