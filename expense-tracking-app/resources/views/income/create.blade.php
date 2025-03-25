<x-app-layout>
    <x-slot name="header">
        <x-heading>
            {{ __('Add Income') }}
        </x-heading>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('income.store')}}" method="post">
                        @csrf

                        <div class="mt-4">
                            <x-input-label for="amount" :value="__('Amount')"/>
                            <x-text-input id="amount" class="block mt-1 w-full" type="number" step="any" name="amount"
                                          :value="old('amount')" required style="width:100%"/>
                            <x-input-error :messages="$errors->get('amount')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')"/>
                            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description"
                                          :value="old('description')" style="width:100%"/>
                            <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="date" :value="__('Date')"/>
                            <input type="date" name="date" id="date" value="{{$current}}"
                                   class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#3268a8] focus:border-[#3268a8]"
                                   style="width:100%">
                            <x-input-error :messages="$errors->get('date')" class="mt-2"/>
                        </div>

                        <x-input-error :messages="session()->get('error')" class="mt-2"/>
                        
                        <x-primary-button class="mt-4" type="submit">Add</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
