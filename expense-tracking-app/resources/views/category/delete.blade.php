<x-guest-layout>
    <div class="p-8 flex items-center justify-center">
        <div class="max-w-lg w-full  rounded-xl">
            <x-heading>
                {{ __('Are you sure you want to delete this category?') }}
            </x-heading>

            <p class="text-gray-600 mt-4 text-sm leading-relaxed">
                Deleting this category will permanently remove it from your records. This action cannot be undone.
            </p>

            <div class="mt-8 flex justify-end space-x-4">
                <form method="post" action="{{ route('category.destroy', $category) }}" class="flex items-center space-x-4">
                    <a href="{{ route('category.index') }}"
                       class="inline-flex items-center px-6 py-2.5 bg-[#0ea5e9] hover:bg-[#0e95d9] text-white rounded-lg font-semibold transition-all duration-300 ease-in-out shadow-md hover:shadow-lg">
                        <i class="fas fa-times mr-2"></i> Cancel
                    </a>
                    
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 bg-[#b50e0b] hover:bg-red-700 text-white rounded-lg font-semibold transition-all duration-300 ease-in-out shadow-md hover:shadow-lg">
                        <i class="fas fa-trash mr-2"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
