<x-app-layout>
    <div class="left-0 w-full border-green-500 bg-green-100 text-green-800 p-4 shadow-lg">
        <span class="ml-4">{{$left}}% of limit is left.</span>
    </div>

    <div class="py-8">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-heading>
                        {{ __('Add Category') }}
                    </x-heading>

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

                        <x-input-error :messages="$error" class="mt-2"/>

                        <x-primary-button class="mt-4">Add</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
