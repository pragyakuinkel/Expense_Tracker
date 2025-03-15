<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table-auto w-fit border-collapse mt-3">
                        <thead>
                        <tr style="background-color: #3268a8;color: white">
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Created Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="border px-4 py-2">
                                    <a href="{{route('admin.category',$user)}}">
                                        {{$user->name}}
                                    </a>
                                </td>
                                <td class="border px-4 py-2">
                                    <a href="{{route('admin.category',$user)}}">
                                        {{$user->email}}
                                    </a>
                                </td>
                                <td class="border px-4 py-2">
                                    <a href="{{route('admin.category',$user)}}">
                                        {{$user->updated_at}}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$users->links()}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
