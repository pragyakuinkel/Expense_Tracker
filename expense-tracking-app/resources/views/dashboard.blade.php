<x-app-layout>
    <x-slot name="header">
        <x-heading class="px-4 py-4">
            Transaction
            @if($search)
                / {{$search}}
            @endif
        </x-heading>
    </x-slot>

    <form action="" method="get" class="my-4 mx-3 w-full">
        <div class="flex items-center space-x-4">
            <input type="hidden" name="start_date" value="{{request('start_date')}}">
            <input type="hidden" name="end_date" value="{{request('end_date')}}">
            <input type="text" name="search" placeholder="Search..."
                   class="px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#0ea5e9] focus:border-[#0ea5e9] transition-all duration-200 ease-in-out bg-white text-gray-700 w-[87.6%]" required>
            <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-[#0ea5e9] hover:bg-[#0d84bf] transition-all duration-200 ease-in-out rounded-lg font-semibold text-white shadow-md hover:shadow-lg">
                <i class="fas fa-search mr-2"></i> Search
            </button>
        </div>
    </form>

    <div>
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                    <div class="p-8 text-gray-900">

                        <x-heading>
                            {{$date}}
                        </x-heading>

                        <form  action="" method="get" class="mb-8" >
                            <div class="w-full flex flex-col sm:flex-row mt-4">
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
                            </div>
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2"/>
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2"/>
                        </form>

                        <div class="mt-6 space-y-10">
                            @forelse($months as $month => $transactions)
                                <div class="space-y-6">
                                    <x-heading class="text-2xl font-semibold text-gray-800 tracking-wide border-b border-gray-200 pb-3">
                                        {{ $month }}
                                    </x-heading>
                                    @foreach($transactions as $transaction)
                                        <div class="flex items-center justify-between py-6 border-b border-gray-200 transition-all duration-300 hover:bg-gray-50 px-4 rounded-lg shadow-sm hover:shadow-md">
                                            <div class="space-y-2">
                                                <p class="font-semibold text-gray-800 text-lg tracking-tight">
                                                    @if($transaction->category)
                                                        {{ $transaction->category->name }}
                                                    @else
                                                        Income
                                                    @endif
                                                </p>
                                                <p class="text-gray-600 text-sm font-medium">
                                                    <i class="fas fa-calendar-alt mr-2 text-[#0ea5e9]"></i>
                                                    {{ $transaction->date }}
                                                </p>
                                                <p class="text-gray-700 font-bold text-xl tracking-tight">
                                                    @if($transaction->category)
                                                        - Rs. {{ number_format($transaction->amount, 2) }}
                                                    @else
                                                        + Rs. {{ number_format($transaction->amount, 2) }}
                                                    @endif
                                                </p>
                                                <p class="text-gray-500 text-sm italic leading-relaxed">
                                                    {{ $transaction->description ?: 'No description' }}
                                                </p>
                                            </div>
                                            <div class="flex space-x-4">
                                                @if($transaction->category)
                                                    <a href="{{ route('expense.edit', $transaction) }}"
                                                       class="inline-flex items-center px-5 py-2 bg-[#0ea5e9] hover:bg-[#0d84bf] transition-all duration-300 ease-in-out rounded-lg font-medium text-white shadow-md hover:shadow-lg">
                                                        <i class="fas fa-edit mr-2"></i> Edit
                                                    </a>
                                                    <a href="{{ route('expense.delete', $transaction) }}"
                                                       class="inline-flex items-center px-5 py-2 bg-red-600 hover:bg-red-700 transition-all duration-300 ease-in-out rounded-lg font-medium text-white shadow-md hover:shadow-lg">
                                                        <i class="fas fa-trash mr-2"></i> Delete
                                                    </a>
                                                @else
                                                    <a href="{{ route('income.edit', $transaction) }}"
                                                       class="inline-flex items-center px-5 py-2 bg-[#0ea5e9] hover:bg-[#0d84bf] transition-all duration-300 ease-in-out rounded-lg font-medium text-white shadow-md hover:shadow-lg">
                                                        <i class="fas fa-edit mr-2"></i> Edit
                                                    </a>
                                                    <a href="{{ route('income.delete', $transaction) }}"
                                                       class="inline-flex items-center px-5 py-2 bg-red-600 hover:bg-red-700 transition-all duration-300 ease-in-out rounded-lg font-medium text-white shadow-md hover:shadow-lg">
                                                        <i class="fas fa-trash mr-2"></i> Delete
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @empty
                                <x-empty-value class="text-center text-gray-600 py-16 text-lg font-medium">
                                    <i class="fas fa-exclamation-circle mr-2 text-gray-500"></i> No Transactions Found...
                                </x-empty-value>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
