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
                    <table class="table-auto border-collapse mt-3 w-full" style="width:100%">
                        <thead>
                        <tr style="background-color: #3268a8;color: white">
                            <th class="px-4 py-2 border">Category</th>
                            <th class="px-4 py-2 border">Owner</th>
                            <th class="px-4 py-2 border">No of Users.</th>
                            <th class="px-4 py-2 border align-middle"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td class="border px-4 py-2">{{$category->name}}</td>
                                <td class="border px-4 py-2">
                                    {{$category->user->name}}
                                </td>
                                <td class="border px-4 py-2">{{$category->users_count ?? 0}}</td>
                                <td class="border px-4 py-2 flex justify-center items-center">
{{--                                    <a--}}
{{--                                        class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white"--}}
{{--                                        style='background-color:#3268a8'--}}
{{--                                        href="{{route('category.edit',$category->id)}}">Edit</a>--}}

                                    <a
                                        class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white w-full"
                                        style='background-color:#b50e0b'
                                        href="{{route('category.delete',$category)}}">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

