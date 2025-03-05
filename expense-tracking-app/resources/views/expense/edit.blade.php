<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Expense') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('expense.update',$expense)}}" method="post">
                        @csrf
                        @method('PUT')
                        <label for="name">Category name:</label><br>

                        <select name="category">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}"
                                @if($expense->category_id == $category->id)
                                    selected
                                @endif
                                >{{$category->name}}</option>
                            @endforeach
                        </select><br>
                        @error('$category')
                        <div>{{$message}}</div>
                        @enderror

                        <label for="amount">Amount:</label><br>
                        <input type="number" step="any" name="amount" value="{{$expense->amount}}"><br>
                        @error('amount')
                        <div>{{$message}}</div>
                        @enderror

                        <label for="description">Description:</label><br>
                        <input type="text" name="description" value="{{$expense->description}}"><br>
                        @error('$description')
                        <div>{{$message}}</div>
                        @enderror

                        <label for="date">Date:</label><br>
                        <input type="date" name="date" value="{{$expense->date}}"><br>
                        @error('$date')
                        <div>{{$message}}</div>
                        @enderror

                        <button type="submit">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
