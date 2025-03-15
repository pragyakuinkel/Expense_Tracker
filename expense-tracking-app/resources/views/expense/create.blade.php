<x-app-layout>
    <x-slot name="header">
        <x-heading>
            {{ __('Add Expense') }}
        </x-heading>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('expense.store')}}" method="post">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Category')" />
                            <select name="category" required class="mt-2 block w-fit px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#3268a8] focus:border-[#3268a8]">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="amount" :value="__('Amount')" />
                            <x-text-input id="amount" class="block mt-1 w-fit" type="number" step="any" name="amount" :value="old('amount')" required />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" class="block mt-1 w-fit" type="text" name="description" :value="old('description')" />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="date" :value="__('Date')" />
                            <input type="date" name="date" id="date" value="{{$current}}" class="mt-2 block w-fit px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#3268a8] focus:border-[#3268a8]">
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <x-primary-button class="mt-4" type="submit">Add</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
