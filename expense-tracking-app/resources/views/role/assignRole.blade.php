<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center px-6 py-4">
            <x-heading class="text-2xl font-bold text-gray-800">
                Add User To {{ $role->name }}
                @if($search)
                    <span class="text-[#0ea5e9]"> / {{ $search }}</span>
                @endif
            </x-heading>
        </div>
    </x-slot>

    <div class="my-6 mx-8">
        <form action="" method="GET" class=" mx-auto">
            <div class="flex items-center space-x-4">
                <input
                    type="text"
                    name="search"
                    placeholder="Search..."
                    value="{{ request('search') }}"
                    class="flex-1 px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#0ea5e9] focus:border-[#0ea5e9] bg-white text-gray-700 placeholder-gray-400 transition-all duration-200 ease-in-out"
                >
                <button
                    type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-[#0ea5e9] hover:bg-[#0e95d9] rounded-lg font-semibold text-white text-sm uppercase tracking-wide shadow-md hover:shadow-lg transition-all duration-200 ease-in-out"
                >
                    <i class="fas fa-search mr-2"></i> Search
                </button>
            </div>
        </form>
    </div>

    <div>
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Success Message -->
                    @if(session('success'))
                        <x-success-message class="mb-6 rounded-lg bg-green-50 text-green-800 border border-green-200 p-4">
                            {{ session('success') }}
                        </x-success-message>
                    @endif

                    <!-- Users List -->
                    <div class="space-y-4">
                        @forelse($users as $user)
                            <div class="flex items-center justify-between py-4 px-4 border-b border-gray-200 hover:bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 ease-in-out">
                                <div class="flex-grow">
                                    <span class="text-gray-800 font-semibold text-lg">
                                        {{ $user->username }}
                                    </span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    @if($user->hasRole($role->id))
                                        <a
                                            href="{{ route('role.removeRole', ['role' => $role, 'user' => $user]) }}"
                                            class="inline-flex items-center px-3 py-1 text-red-600 hover:text-red-800 font-medium text-sm transition-all duration-200 ease-in-out"
                                        >
                                            <i class="fas fa-minus-circle mr-2"></i> Remove
                                        </a>
                                    @else
                                        <a
                                            href="{{ route('role.addRole', ['role' => $role, 'user' => $user]) }}"
                                            class="inline-flex items-center px-3 py-1 text-[#0ea5e9] hover:text-[#0e95d9] font-medium text-sm transition-all duration-200 ease-in-out"
                                        >
                                            <i class="fas fa-plus-circle mr-2"></i> Add
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <x-empty-value class="text-center text-gray-600 py-16 text-lg font-medium">
                                <i class="fas fa-exclamation-circle mr-2 text-gray-500"></i> No Users Found...
                            </x-empty-value>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
