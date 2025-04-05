<x-app-layout>
    <x-slot name="header">
        <div class="px-6 py-5 ">
            <x-heading>
                Manage User
                @if($search)
                    / {{$search}}
                @endif
            </x-heading>
        </div>
    </x-slot>

    <form action="{{ route('admin.manageUser') }}" method="GET" class="my-4 mx-8">
        <input type="hidden" name="start_date" value="{{request('start_date')}}">
        <input type="hidden" name="end_date" value="{{request('end_date')}}">
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
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-8 text-gray-900">
                    <x-heading>
                        {{$date}}
                    </x-heading>

                    <form action="" method="get" class="w-full mb-8 flex flex-col sm:flex-row">
                        <div class="flex-1">
                            <label for="start-date" class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                            <input type="date" id="start-date" name="start_date" value="{{request('start_date')}}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#0ea5e9] focus:border-[#0ea5e9] transition duration-150 ease-in-out" required>
                        </div>
                        <div class="flex-1 ml-4">
                            <label for="end-date" class="block text-sm font-medium text-gray-700 mb-2" >End Date</label>
                            <input type="date" id="end-date" name="end_date" value="{{request('end_date')}}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#0ea5e9] focus:border-[#0ea5e9] transition duration-150 ease-in-out" required>
                        </div>
                        <div class="flex items-end ml-4">
                            <button type="submit"
                                    class="inline-flex items-center px-5 py-2.5 bg-[#0ea5e9] hover:bg-[#0d84bf] transition-all duration-200 ease-in-out rounded-md font-semibold text-white shadow-md hover:shadow-lg">
                                <i class="fas fa-filter mr-2"></i> Filter
                            </button>
                        </div>
                    </form>
                    <div class="overflow-x-auto mt-2">
                        <table class="w-full table-auto border-collapse text-left">
                            <thead>
                            <tr class="bg-[#0ea5e9] text-white">
                                <th class="px-6 py-3 font-semibold">Name</th>
                                <th class="px-6 py-3 font-semibold">Email</th>
                                <th class="px-6 py-3 font-semibold">Username</th>
                                <th class="px-6 py-3 font-semibold">Role</th>
                                <th class="px-6 py-3 font-semibold">Created Date</th>
                                <th class="px-6 py-3 font-semibold"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-all duration-200">
                                    <td class="px-6 py-4">{{ $user->name }}</td>
                                    <td class="px-6 py-4">{{ $user->email }}</td>
                                    <td class="px-6 py-4">{{ $user->username }}</td>
                                    <td class="px-6 py-4">
                                        @foreach($user->roles as $role)
                                            {{$role->name}}<br>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4">{{ $user->updated_at }}</td>
                                    <td class="px-6 py-4 flex justify-center items-center">
                                        <a href="{{ route('admin.manageUserCategory', $user) }}"
                                           class="inline-flex items-center px-4 py-2 text-green-600 hover:text-green-700 font-semibold transition-all duration-200 ease-in-out">
                                            <i class="fas fa-eye mr-2"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-600 py-16 text-lg font-medium">
                                            <i class="fas fa-exclamation-circle mr-2 text-gray-500"></i> No Users Found...
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
