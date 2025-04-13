<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between px-6 py-5">
            <x-heading>
                Manage Category
                @if($search)
                    / {{$search}}
                @endif
            </x-heading>
            <a href="{{ route('category.create') }}"
               class="inline-flex items-center px-6 py-2 bg-[#0ea5e9] hover:bg-[#0e95d9] transition-all duration-300 ease-in-out rounded-lg font-semibold text-white shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i> Add New Category
            </a>
        </div>
    </x-slot>

    <form action="{{ route('category.index') }}" method="GET" class="my-4 mx-4">
        <div class="flex items-center space-x-4">
            <input type="hidden" name="start_date" value="{{request('start_date')}}">
            <input type="hidden" name="end_date" value="{{request('end_date')}}">
            <input type="text" name="search" placeholder="Search..."
                   class="px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#0ea5e9] focus:border-[#0ea5e9] transition-all duration-200 ease-in-out bg-white text-gray-700  w-[89%]" required>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-[#0ea5e9] hover:bg-[#0d84bf] transition-all duration-200 ease-in-out rounded-lg font-semibold text-white shadow-md hover:shadow-lg">
                <i class="fas fa-search mr-2"></i> Search
            </button>
        </div>
    </form>

    <div>
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-8 text-gray-900">
                    @if(session('success'))
                        <x-success-message>
                            {{ session('success') }}
                        </x-success-message>
                    @endif

                    <div class="overflow-x-auto">

                        <x-heading>
                            {{$date}}
                        </x-heading>

                        <form action="" method="get" class="w-full mb-8 flex flex-col sm:flex-row">
                            <input type="hidden" name="search" value="{{request('search')}}">
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

                        <table class="w-full table-auto border-collapse text-left mb-4">
                            <thead>
                            <tr class="bg-[#0ea5e9] text-white">
                                <th class="px-6 py-3 font-semibold">Category</th>
                                <th class="px-6 py-3 font-semibold">Owner</th>
                                <th class="px-6 py-3 font-semibold">No. of Users</th>
                                <th class="px-6 py-3 font-semibold">Date</th>
                                <th class="px-6 py-3 font-semibold"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($categories as $category)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-all duration-200">
                                    <td class="px-6 py-4">{{ $category->name }}</td>
                                    <td class="px-6 py-4">{{ $category->user->name }}</td>
                                    <td class="px-6 py-4">{{ $category->users_count ?? 0 }}</td>
                                    <td class="px-6 py-4">{{ $category->updated_at->format('d M, Y') }}</td>
                                    <td class="px-6 py-4 flex justify-center items-center space-x-3">
                                        <a href="{{ route('category.edit', $category->id) }}"
                                           class="inline-flex items-center px-4 py-2 bg-[#0ea5e9] hover:bg-[#0e95d9] transition-all duration-300 ease-in-out rounded-md font-semibold text-white shadow-md hover:shadow-lg">
                                            <i class="fas fa-edit mr-2"></i> Edit
                                        </a>
                                        <a href="{{ route('category.deleteConfirmation', $category) }}"
                                           class="inline-flex items-center px-4 py-2 bg-[#b50e0b] hover:bg-red-700 transition-all duration-300 ease-in-out rounded-md font-semibold text-white shadow-md hover:shadow-lg">
                                            <i class="fas fa-trash mr-2"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-gray-600 py-16 text-lg font-medium">
                                        <i class="fas fa-exclamation-circle mr-2 text-gray-500"></i> No Categories Found...
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{$categories->links()}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
