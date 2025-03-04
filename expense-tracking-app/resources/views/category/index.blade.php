<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Category') }}
        </h2>

        <a href="{{route('category.create')}}">Add Category</a><br>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        {{$success}}
                    </div>
                    @forelse($categories as $category)
                        <p>{{$category->name}}</p>

                        <a href="{{route('category.edit',$category)}}">Edit</a>

                        <a href="{{route('category.delete',$category)}}">Delete</a>
                    @empty
                        <p>No Categories Yet..</p>
                    @endforelse
                    {{$categories->links()}}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
