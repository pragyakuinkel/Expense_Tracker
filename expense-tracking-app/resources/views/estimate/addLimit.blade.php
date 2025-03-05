<x-guest-layout>
    <div class="p-6">
        <h2 class="text-lg font-medium dark:text-gray-100">
            {{ __('Add Limit') }}
        </h2>

        <div class="mt-6 ">
            <form action="{{route('addLimit')}}" method="post">
                @csrf
                @foreach($categories as $category)
                    <label>
                        {{ $category }}
                    </label>
                        <input type="hidden" step="any" name="categories[]" value="{{$category}}"><br>
                        <input type="number" step="any" name="limits[]" required><br>
                @endforeach

                @foreach($new_categories as $category)
                    <label>
                        {{ $category }}
                    </label>
                        <input type="hidden" step="any" name="new_categories[]" value="{{$category}}"><br>
                        <input type="number" step="any" name="new_limits[]" required><br>
                @endforeach

                <button type="submit">Add</button>
            </form>
        </div>
    </div>
</x-guest-layout>
