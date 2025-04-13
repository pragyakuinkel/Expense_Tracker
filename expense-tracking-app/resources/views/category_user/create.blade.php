<x-app-layout>
    <div class="left-0 w-full border-green-500 bg-green-100 text-green-800 p-4 shadow-lg">
        <span class="ml-4">{{$left}}% of limit is left.</span>
    </div>

    <div class="py-8">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <x-heading>
                            Add Category / {{\Carbon\Carbon::parse(request('date'))->format('F, Y') ?? \Carbon\Carbon::now()->format('F, Y')}}
                        </x-heading>

                        <form action="" method="get"
                              class=" flex flex-col sm:flex-row">
                            <div class="flex-1">
                                <label for="date" class="block text-sm font-medium text-gray-700 ">Select Date</label>
                                <input type="month" id="date" name="date"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#0ea5e9] focus:border-[#0ea5e9] transition duration-150 ease-in-out"
                                       required>
                            </div>
                            <div class="flex items-end ml-4">
                                <button type="submit"
                                        class="inline-flex items-center px-5 py-2.5 bg-[#0ea5e9] hover:bg-[#0d84bf] transition-all duration-200 ease-in-out rounded-md font-semibold text-white shadow-md hover:shadow-lg">
                                    <i class="fas fa-filter mr-2"></i> Select
                                </button>
                            </div>
                        </form>
                    </div>

                    <form action="{{ route('category_user.store') }}" method="post">
                        @csrf

                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Name')"/>
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                          :value="old('name')"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <x-input-label class="block w-full">
                                Limit
                            </x-input-label>
                            <x-text-input type="number" step="any" name="limit" required class="block mt-1 w-full" :value="old('limit')"/>
                            <x-input-error :messages="$errors->get('limit')" class="mt-2"/>
                        </div>

                        <input type="hidden" name="date" value="{{request('date')}}">
                        <x-input-error :messages="$error" class="mt-2"/>

                        <x-primary-button class="mt-4">Add</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
