<x-app-layout>
    <x-slot name="header">
        <x-heading>
            {{"Dashboard"}}
        </x-heading>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6">
                    <div class="p-4 text-gray-900 text-center w-full">
                        @foreach($transaction as $item)
                            <div>
                                <span class="font-semibold text-lg">{{ number_format($item['income'],2) }} - {{ number_format($item['expense'],2) }} = {{ number_format($item['left'],2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
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
                                                @endif Rs. {{ number_format($transaction->amount,2) }}</small>

                                            <p>
                                                {{$transaction->description}}
                                            </p>
                                        </div>

                                        <div>
                                            @if($transaction->category)
                                                <a
                                                    class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white"
                                                    style='background-color:#3268a8'
                                                    href="{{route('expense.edit',$transaction)}}">Edit</a>

                                                <a
                                                    class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white"
                                                    style='background-color:#b50e0b'
                                                    href="{{route('expense.delete',$transaction)}}">Delete</a>
                                            @else
                                                <a
                                                    class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white"
                                                    style='background-color:#3268a8'
                                                    href="{{route('income.edit',$transaction)}}">Edit</a>

                                                <a
                                                    class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white"
                                                    style='background-color:#b50e0b'
                                                    href="{{route('income.delete',$transaction)}}">Delete</a>
                                            @endif

                                        </div>
                                    </div>
                                    <hr class="mt-4">
                                @endforeach
                            @empty
                                <x-empty-value>
                                    No Transactions Yet....
                                </x-empty-value>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
