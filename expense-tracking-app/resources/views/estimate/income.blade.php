<x-guest-layout>
    <div class="p-6">

        <x-heading>
            {{ __('Enter Your Estimate Income Amount') }}
        </x-heading>


        <div class="mt-6 w-full" style="width:100%">
            <form method="post" action="{{route('estimate.addIncome')}}">
                @csrf

                <div>
                    <select name="type" required
                            class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#3268a8] focus:border-[#3268a8]"
                            style="width:100%">
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>

                <div class="mt-4">
                    <x-input-label for="number" :value="__('Income')"/>
                    <x-text-input id="amount" class="block mt-1 w-full" type="number" step="any" name="amount"
                                  :value="old('amount')" required style="width:100%"/>
                    <x-input-error :messages="$errors->get('amount')" class="mt-2"/>
                </div>

                <x-input-error :messages="session()->get('error')" class="mt-2"/>

                <x-primary-button class="mt-4">
                    {{ __('Add Income') }}
                </x-primary-button>
            </form>
        </div>
    </div>
</x-guest-layout>
