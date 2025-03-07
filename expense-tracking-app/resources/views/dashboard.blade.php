<x-app-layout>
    <x-slot name="header">
        <x-heading>
            {{"Dashboard"}}
        </x-heading>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                        <x-success-message>
                            {{ session('success') }}
                        </x-success-message>
                    @endif


                    <div class="mt-3">
                        @forelse($months as $month => $expenses )
                            <x-heading>
                                {{$month}}
                            </x-heading>
                            @foreach($expenses as $expense)
                                <div class="flex row justify-between mt-3">
                                    <div>
                                        <p class="font-medium">
                                            {{ $expense->category->name }}
                                        </p>

                                        <small>- {{ $expense->amount }}</small>

                                        <p>
                                            {{$expense->description}}
                                        </p>
                                    </div>

                                    <div>
                                        <a
                                        class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white"
                                        style='background-color:#3268a8'
                                            href="{{route('expense.edit',$expense)}}">Edit</a>

                                        <a
                                            class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white"
                                            style='background-color:#b50e0b'
                                            href="{{route('expense.delete',$expense)}}">Delete</a>
                                    </div>
                                </div>
                            @endforeach
                            <hr>
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
