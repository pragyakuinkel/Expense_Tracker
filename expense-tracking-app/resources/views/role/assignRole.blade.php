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
                        <div class="border px-4 py-2 flex justify-between">


                            @if($user->hasRole($role->id))
                                -
                            @else
                                +
                            @endif

                            {{$user->name}}

                        </div>


                    @endforeach
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

