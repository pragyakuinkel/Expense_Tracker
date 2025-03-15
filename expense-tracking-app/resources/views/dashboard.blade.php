<x-app-layout>
    <x-slot name="header">
        <x-heading>
            {{"Dashboard"}}
        </x-heading>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-4 text-gray-900 text-center w-fit">
                    @foreach($transaction as $item)
                        <div>
                            <span class="font-semibold text-lg">{{ $item['income'] }} - {{ $item['expense'] }} = {{ $item['left'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                        <x-success-message>
                            {{ session('success') }}
                        </x-success-message>
                    @endif

                    <div class="mt-3">
                        @forelse($months as $month => $transactions )
                            <x-heading>
                                {{$month}}
                            </x-heading>
                            @foreach($transactions as $transaction)
                                <div class="flex row justify-between mt-3">
                                    <div>

                                        <p class="font-medium">
                                            @if($transaction->category)
                                                {{ $transaction->category->name }}
                                            @else
                                                Income
                                            @endif
                                        </p>

                                        <small>
                                            @if($transaction->category)
                                                -
                                            @else
                                                   +
                                            @endif Rs. {{ $transaction->amount }}</small>

                                        <p>
                                            {{$transaction->description}}
                                        </p>
                                    </div>

                                    <div>
                                        <a
                                            class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white"
                                            style='background-color:#3268a8'
                                            href="{{route('expense.edit',$transaction)}}">Edit</a>

                                        <a
                                            class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white"
                                            style='background-color:#b50e0b'
                                            href="{{route('expense.delete',$transaction)}}">Delete</a>
                                    </div>
                                </div>
                            <hr class="mt-4">
                            @endforeach
                        @empty
                            <x-empty-value>
                                No Expense Yet....
                            </x-empty-value>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
