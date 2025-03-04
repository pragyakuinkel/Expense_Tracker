<x-guest-layout>
    <div class="p-6">
        <h2 class="text-lg font-medium dark:text-gray-100">
            {{ __('Enter Your Estimate Income Amount') }}
        </h2>

        <div class="mt-6 flex justify-end">
            <form method="post" action="{{route('addIncome')}}">
                @csrf
                <select name="type" required>
                    <option value="monthly"> Monthly </option>
                    <option value="yearly"> Yearly </option>
                </select>

                <input type="number" step="any" placeholder="Income" name="amount" required>

                @error('amount')
                <div>{{$message}}</div>
                @enderror

                <button type="submit">Add Income</button>
            </form>
        </div>
    </div>
</x-guest-layout>
