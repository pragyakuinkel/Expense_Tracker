<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('category.update',$category)}}" method="post">
                        @csrf
                        @method('PUT')

                        <label for="name">Category name:</label><br>

                        <input type="text" name="name" id="name" value="{{$category->name}}"><br>

                        @error('name')
                        <div>{{ $message }}</div><br>
                        @enderror

                        <button type="submit">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
