<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        {{$success}}
                    </div>

                    <div>
                        @forelse($months as $month => $expenses )
                            <h2>{{$month}}</h2>
                            @foreach($expenses as $expense)
                                <div>
                                    {{ $expense->category->name }} <br> <small>- {{ $expense->amount }}</small><br>

                                    <a href="{{route('expense.edit',$expense)}}">Edit</a>

                                    <a href="{{route('expense.delete',$expense)}}">Delete</a>
                                </div>
                            @endforeach
                            <hr>
                        @empty
                            <p>No Expense Yet....</p>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
