<x-guest-layout>
    <div class="p-6">
        <h2 class="text-lg font-medium dark:text-gray-100">
            {{ __('Are you sure you want to delete this expense?') }}
        </h2>

        <div class="mt-6 flex justify-end">
            <form method="post" action="{{ route('expense.destroy', $expense) }}">
                <a href="{{ route('dashboard') }}" type="submit">Cancel</a>
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </div>
    </div>
</x-guest-layout>
