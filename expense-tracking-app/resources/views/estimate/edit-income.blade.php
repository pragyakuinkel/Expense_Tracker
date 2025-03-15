<x-guest-layout>
    <div class="p-6 text-center">

        <x-heading>
            Edit {{$month}} Income
        </x-heading>


        <div class="mt-6 w-fit">
            <form method="post" action="{{route('updateIncome',$estimate)}}">
                @csrf
                @method('PUT')

                <div class="mt-4">
                <x-input-label for="number" :value="__('Income')" />
                <x-text-input id="amount" class="block mt-1 w-fit" type="number" step="any" name="amount" :value="old('amount',$estimate->amount)" required />
                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                </div>

                <x-primary-button class="mt-4">
                    {{ __('Edit Income') }}
                </x-primary-button>
            </form>
        </div>
    </div>
</x-guest-layout>
