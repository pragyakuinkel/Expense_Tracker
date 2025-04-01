<x-app-layout>
    <x-slot name="header">

        <div class="flex row justify-between">
            <x-heading>
                {{"Forecast"}}
            </x-heading>

            <a
                class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white"
                style='background-color:#3268a8'
                href="{{route('estimate.editIncome',$monthSelected)}}">Edit Estimate {{$monthSelected}}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-heading>
                        {{$monthSelected}}
                    </x-heading>

                    @if(session('success'))
                        <x-success-message>
                            {{ session('success') }}
                        </x-success-message>
                    @endif


                    @php
                        $months=['January','February','March','April',
                        'May','June','July','August','September','October',
                        'November','December'];
                    @endphp

                    <div class="flex gap-4 mt-3">
                        @for($i=0; $i<count($months);$i++)
                            <a href="{{route('forecast.forecast',$months[$i])}}"
                               @if($months[$i] === $monthSelected)
                                   style="font-weight: bolder;background-color: #2f4e73;color: white"
                               @endif
                               style="background-color: #3268a8;color: white"
                               class="px-3 py-2 rounded mb-2"
                            >{{$months[$i]}}</a>
                        @endfor
                    </div>

                    <hr>

                    <table class="table-auto border-collapse mt-3 w-full" style="width:100%">
                        <thead>
                        <tr style="background-color: #3268a8;color: white">
                            <th class="px-4 py-2 border">Category</th>
                            <th class="px-4 py-2 border">Predicted Expense %</th>
                            <th class="px-4 py-2 border">Predicted Expense</th>
                            <th class="px-4 py-2 border">Actual Expense %</th>
                            <th class="px-4 py-2 border">Actual Expense</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($forecasts as $forecast)
                            <tr>
                                <td class="border px-4 py-2">{{$forecast['category']}}</td>
                                <td class="border px-4 py-2">{{$forecast['limit']}}%</td>
                                <td class="border px-4 py-2">Rs. {{number_format($forecast['estimate'],2)}}</td>
                                <td class="border px-4 py-2">{{$forecast['expensePercent']}}%</td>
                                <td class="border px-4 py-2">Rs.{{number_format($forecast['expense'],2)}}</td>
                            </tr>
                        @endforeach
                        <tr class="border px-4 py-2">
                            <td class="border px-4 py-2"></td>
                            <td class="border px-4 py-2"></td>
                            <td class="border px-4 py-2">Rs. {{number_format($expectedExpense,2)}}</td>
                            <td class="border px-4 py-2"></td>
                            <td class="border px-4 py-2">Rs.{{number_format($actualExpense,2)}}</td>
                        </tr>
                        </tbody>
                    </table>

                    <p class="font-bold text-xl mt-4">Estimated Income: Rs.{{number_format($estimate->amount,2)}}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
