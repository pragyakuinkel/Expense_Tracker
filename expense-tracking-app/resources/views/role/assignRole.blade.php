<x-app-layout>
    <x-slot name="header">
        <div class="flex row justify-between">
            <x-heading>
                Add User To {{$role->name}}
            </x-heading>
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

                        @foreach($users as $user)
                            <div class="border-b px-4 py-3 flex items-center justify-between">
                                <div class="flex-grow text-sm text-gray-800">
                                    {{$user->username}}
                                </div>

                                <div class="flex items-center space-x-3">
                                    @if($user->hasRole($role->id))
                                        <a href="{{ route('role.removeRole', ['role' => $role, 'user' => $user]) }}"
                                           class="text-red-600 hover:text-red-800 font-semibold">
                                            Remove
                                        </a>
                                    @else
                                        <a href="{{ route('role.addRole', ['role' => $role, 'user' => $user]) }}"
                                           class="text-green-600 hover:text-green-800 font-semibold">
                                            Add
                                        </a>
                                    @endif
                                </div>



                            </div>
                        @endforeach
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

