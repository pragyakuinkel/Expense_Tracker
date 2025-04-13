<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between px-6 py-5">
            <x-heading>
                Forecast
            </x-heading>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto sm:px-6 lg:px-8">
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

                        <form action="" method="get"
                              class=" flex flex-col sm:flex-row">
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
                    <hr class="my-6 border-gray-200">

                    <div class="overflow-x-auto">
                        <table class="w-full table-auto border-collapse text-left">
                            <thead>
                            <tr class="bg-[#0ea5e9] text-white">
                                <th class="px-6 py-3 font-semibold">Category</th>
                                <th class="px-6 py-3 font-semibold">Predicted Expense %</th>
                                <th class="px-6 py-3 font-semibold">Predicted Expense</th>
                                <th class="px-6 py-3 font-semibold">Actual Expense %</th>
                                <th class="px-6 py-3 font-semibold">Actual Expense</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($forecasts as $forecast)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-all duration-200">
                                    <td class="px-6 py-4">{{ $forecast['category'] }}</td>
                                    <td class="px-6 py-4">{{ $forecast['limit'] }}%</td>
                                    <td class="px-6 py-4">Rs. {{ number_format($forecast['estimate'], 2) }}</td>
                                    <td class="px-6 py-4">{{ $forecast['expensePercent'] }}%</td>
                                    <td class="px-6 py-4">Rs. {{ number_format($forecast['expense'], 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="border-t border-gray-300 font-semibold text-gray-800">
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4">Rs. {{ number_format($expectedExpense, 2) }}</td>
                                <td class="px-6 py-4"></td>
                                <td class="px-6 py-4">Rs. {{ number_format($actualExpense, 2) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <p class="mt-6 text-xl font-bold text-gray-800">
                        Income: Rs. {{ number_format($estimate ?? 0, 2)  }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
