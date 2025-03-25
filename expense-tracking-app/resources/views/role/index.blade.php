<x-app-layout>
    <x-slot name="header">
        <div class="flex row justify-between">
            <x-heading>
                {{"Add New Role"}}
            </x-heading>

            <a
                class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white"
                style='background-color:#3268a8'
                href="{{route('role.create')}}">Add New Role</a>
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

                    @foreach($roles as $role)
                        <div class="border px-4 py-2 flex justify-between">
                            {{$role->name}}

                            <a href="{{route('role.assignRole',$role)}}" style="color: green">View</a>
                        </div>

                    @endforeach
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

