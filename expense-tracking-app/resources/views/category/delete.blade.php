<x-guest-layout>
    <div class="p-6">
        <x-heading>
            {{ __('Are you sure you want to delete this category?') }}
        </x-heading>

        <p class="text-gray-600 mt-3">
            Deleting this category will permanently remove it from your records. This action cannot be undone.
        </p>

        <div class="mt-6 flex justify-end">
            <form method="post" action="{{ route('category.destroy', $category) }}">
                <a  class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white"
                    style='background-color:#3268a8'
                    href="{{ route('category.index') }}" type="submit">Cancel</a>
                @csrf
                @method('DELETE')
                <button
                    class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-white"
                    style='background-color:#b50e0b'
                    type="submit">Delete</button>
            </form>
        </div>
    </div>
</x-guest-layout>
