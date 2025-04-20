<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between px-6 py-5 ">
            <x-heading>
                Manage Category
                @if($search)
                    / {{$search}}
                @endif
            </x-heading>
            <a href="{{ route('category_user.create', ['date' =>request('date')]) }}"
               class="inline-flex items-center px-6 py-2 bg-[#0ea5e9] hover:bg-[#0d84bf] transition-all duration-300 ease-in-out rounded-lg font-semibold text-white shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i> Add New Category
            </a>
        </div>
    </x-slot>

    <form action="" method="GET" class="my-4 mx-4">
        <div class="flex items-center space-x-4">
            <input type="hidden" name="date" value="{{request('date')}}">
            <input type="text" name="search" placeholder="Search..."
                   class="px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#0ea5e9] focus:border-[#0ea5e9] transition-all duration-200 ease-in-out bg-white text-gray-700  w-[89%]" required>
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
                    @if(session('success'))
                        <x-success-message>
                            {{ session('success') }}
                        </x-success-message>
                    @endif

                    <div class="flex justify-between items-center">
                        <x-heading>
                            {{$date->format('F Y')}}
                        </x-heading>

                        <form action="{{ route('category_user.monthlyCategory') }}" method="get"
                              class=" flex flex-col sm:flex-row">
                            <input type="hidden" name="search" value="{{request('search')}}">

                            <div class="flex-1 ml-4">
                                <label for="date" class="block text-sm font-medium text-gray-700 ">Select Date</label>
                                <input type="month" id="date" name="date"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#0ea5e9] focus:border-[#0ea5e9] transition duration-150 ease-in-out"
                                       required>
                            </div>

                            <div class="flex items-end ml-4">
                                <button type="submit"
                                        class="inline-flex items-center px-5 py-2.5 bg-[#0ea5e9] hover:bg-[#0d84bf] transition-all duration-200 ease-in-out rounded-md font-semibold text-white shadow-md hover:shadow-lg">
                                    <i class="fas fa-filter mr-2"></i> Filter
                                </button>
                            </div>
                        </form>
                    </div>

                    <x-input-error :messages="$errors->get('date')" class="mt-2"/>

                    <div class="mt-4 space-y-6">
                        @forelse ($categories as $category)
                            <div
                                class="flex items-center justify-between py-4 border-b border-gray-200 transition-all duration-300 hover:bg-gray-50 px-4 rounded-lg shadow-sm hover:shadow-md">
                                <div class="font-semibold text-gray-800 text-lg tracking-tight">
                                    {{ $category->name }}
                                </div>
                                <div class="flex space-x-4">

                                    <form action="{{ route('category_user.edit', $category->id) }}" method="get">
                                        <input type="hidden" name="date" value="{{$date->format('Y-m-d')}}">

                                        <button type="submit"
                                                class="inline-flex items-center px-5 py-2 bg-[#0ea5e9] hover:bg-[#0d84bf] transition-all duration-300 ease-in-out rounded-lg font-medium text-white shadow-md hover:shadow-lg">
                                            <i class="fas fa-edit mr-2"></i> Edit
                                        </button>
                                    </form>

                                    <a href="{{ route('category_user.delete',[$category, $date->format('Y-m-d')] ) }}"
                                       class="inline-flex items-center px-5 py-2 bg-red-600 hover:bg-red-700 transition-all duration-300 ease-in-out rounded-lg font-medium text-white shadow-md hover:shadow-lg">
                                        <i class="fas fa-trash mr-2"></i> Delete
                                    </a>
                                </div>

                            </div>
                        @empty
                            <x-empty-value class="text-center text-gray-500 py-12 text-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i> No Categories Added...
                            </x-empty-value>
                        @endforelse
                    </div>
                        {{$categories->links()}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
