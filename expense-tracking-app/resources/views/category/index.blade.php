<x-app-layout>
    <x-slot name="header">
        <div class="flex row justify-between">
            <x-heading>
                {{"Manage Category"}}
            </x-heading>

            <a
                class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white"
                style='background-color:#3268a8'
                href="{{route('category.create')}}">Add New Category</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <x-success-message>
                            {{ session('success') }}
                        </x-success-message>
                    @endif
                        @forelse($categories as $category)
                            <div class="flex row justify-between mt-3">
                                <div class="font-medium">
                                    {{$category->name}}
                                </div>
                                <div>
                                    <a
                                        class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white"
                                        style='background-color:#3268a8'
                                        href="{{route('category.edit',$category->id)}}">Edit</a>

                                    <a
                                        class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white"
                                        style='background-color:#b50e0b'
                                        href="{{route('category.delete',$category)}}">Delete</a>
                                </div>
                            </div>
                    @empty
                            <x-empty-value>
                                No Categories Yet....
                            </x-empty-value>
                    @endforelse
                    {{$categories->links()}}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
