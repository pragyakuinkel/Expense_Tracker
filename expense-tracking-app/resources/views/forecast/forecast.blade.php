<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$monthSelected}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @php
                        $months=['January','February','March','April',
                        'May','June','July','August','September','October',
                        'November','December'];
                    @endphp

                    @for($i=0; $i<count($months);$i++)
                        <a href="{{route('forecast.forecast',$months[$i])}}"
                        @if($months[$i] === $monthSelected)
                            style="font-weight: bolder"
                        @endif
                        >{{$months[$i]}}</a>
                    @endfor

                    <table class="w-full text-left">
                        <thead>
                        <tr>
                            <th>Category</th>
                            <th>Predicted Expense %</th>
                            <th>Predicted Expense</th>
                            <th>Actual Expense %</th>
                            <th>Actual Expense</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        @foreach($forecasts as $forecast)
                           <td>
                               <tr>
                                   <td>{{$forecast['category']}}</td>
                                   <td>{{$forecast['limit']}}%</td>
                                   <td>Rs. {{$forecast['estimate']}}</td>
                                   <td>{{$forecast['expensePercent']}}%</td>
                                   <td>Rs.{{$forecast['expense']}}</td>
                               </tr>
                           </td>
                        @endforeach
                        <td>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Rs. {{$expectedExpense}}</td>
                                <td></td>
                                <td>Rs.{{$actualExpense}}</td>
                            </tr>
                        </td>
                        </tbody>
                    </table>

                    <p>Income: Rs.{{$estimate->amount}}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
