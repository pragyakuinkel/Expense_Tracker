<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center px-6 py-4">
            <x-heading class="text-xl font-bold">
                Roles
                @if($search)
                    / {{$search}}
                @endif
            </x-heading>
            <a href="{{ route('role.create') }}"
               class="inline-flex items-center px-6 py-2 bg-[#0ea5e9] hover:bg-[#0e95d9] transition-all duration-300 ease-in-out rounded-lg font-semibold text-white shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i> Add New Role
            </a>
        </div>
    </x-slot>

    <form action="" method="GET" class="my-4 mx-8">
        <div class="flex items-center space-x-4">
            <input type="text" name="search" placeholder="Search..." value="{{request('search')}}"
                   class="w-full px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#0ea5e9] focus:border-[#0ea5e9] transition-all duration-200 ease-in-out bg-white text-gray-700" required>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-[#0ea5e9] hover:bg-[#0d84bf] transition-all duration-200 ease-in-out rounded-lg font-semibold text-white shadow-md hover:shadow-lg">
                <i class="fas fa-search mr-2"></i> Search
            </button>
        </div>
    </form>

    <div>
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <x-success-message class="mb-6">
                            {{ session('success') }}
                        </x-success-message>
                    @endif

                    <div class="space-y-2">
                        @forelse($roles as $role)
                            <div class="flex justify-between items-center px-4 py-3 rounded-md hover:bg-gray-50 transition-colors">
                                <span class="text-gray-800 font-medium">
                                    {{ $role->name }}
                                </span>

                                <a href="{{ route('role.assignRole', $role) }}"
                                   class="inline-flex items-center px-4 py-2 text-green-600 hover:text-green-700 font-semibold transition-all duration-200 ease-in-out">
                                    <i class="fas fa-eye mr-2"></i> View
                                </a>
                            </div>
                            <hr>

                        @empty
                            <x-empty-value class="text-center text-gray-600 py-16 text-lg font-medium">
                                <i class="fas fa-exclamation-circle mr-2 text-gray-500"></i> No Roles Found...
                            </x-empty-value>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
