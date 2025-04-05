<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4">
            <x-heading class="text-3xl font-bold text-gray-800 tracking-tight">
                Incomes
                @if($search)
                     / {{$search}}
                @endif
            </x-heading>
            <a href="{{ route('income.create') }}"
               class="inline-flex items-center px-5 py-2.5 bg-[#0ea5e9] hover:bg-[#0d84bf] transition-all duration-200 ease-in-out rounded-lg font-semibold text-white shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i> Add Income
            </a>
        </div>
    </x-slot>

    <form action="" method="get" class="my-4 mx-8">
        <div class="flex items-center space-x-4">
            <input type="hidden" name="start_date" value="{{request('start_date')}}">
            <input type="hidden" name="end_date" value="{{request('end_date')}}">
            <input type="text" name="search" placeholder="Search..."
                   class="w-full px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#0ea5e9] focus:border-[#0ea5e9] transition-all duration-200 ease-in-out bg-white text-gray-700" required>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-[#0ea5e9] hover:bg-[#0d84bf] transition-all duration-200 ease-in-out rounded-lg font-semibold text-white shadow-md hover:shadow-lg">
                <i class="fas fa-search mr-2"></i> Search
            </button>
        </div>
    </form>

    <div>
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl">
                <div class="p-8 text-gray-900">

                    <div class="mt-4 space-y-10">
                        <div class="space-y-6">

                            @if(session('success'))
                                <x-success-message class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg shadow-sm transition-opacity duration-300">
                                    {{ session('success') }}
                                </x-success-message>
                            @endif

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

                            <div class="space-y-8">
                                @forelse($incomes as $income)
                                    <div class="flex items-center justify-between pb-6 border-b border-gray-200 transition-all duration-200 hover:bg-gray-50 px-2 rounded-md">
                                        <div class="space-y-2">
                                            <p class="text-gray-600 font-semibold text-xl tracking-tight">
                                                Rs. {{ number_format($income->amount, 2) }}
                                            </p>
                                            <p class="text-gray-600 text-sm font-medium">
                                                <i class="fas fa-calendar-alt mr-2 text-[#0ea5e9]"></i>
                                                {{ $income->date }}
                                            </p>
                                            <p class="text-gray-500 text-sm italic">
                                                {{ $income->description ?: 'No description' }}
                                            </p>
                                        </div>
                                        <div class="flex space-x-4">
                                            <a href="{{ route('income.edit', $income) }}"
                                               class="inline-flex items-center px-4 py-2 bg-[#0ea5e9] hover:bg-[#0d84bf] transition-all duration-200 ease-in-out rounded-md font-medium text-white shadow-sm hover:shadow-md">
                                                <i class="fas fa-edit mr-2"></i> Edit
                                            </a>
                                            <a href="{{ route('income.delete', $income) }}"
                                               class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 transition-all duration-200 ease-in-out rounded-md font-medium text-white shadow-sm hover:shadow-md">
                                                <i class="fas fa-trash mr-2"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <x-empty-value class="text-center text-gray-500 py-12 text-lg">
                                        <i class="fas fa-exclamation-circle mr-2"></i> No Income Yet...
                                    </x-empty-value>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        {{ $incomes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
