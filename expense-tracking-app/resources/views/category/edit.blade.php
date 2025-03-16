<x-app-layout>
    <x-slot name="header">
        <x-heading>
            {{ __('Edit Category') }}
        </x-heading>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('category.update',$category)}}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name',$category->name)" style="width:100%"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <x-primary-button class="mt-4">Edit</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>
</x-app-layout>
