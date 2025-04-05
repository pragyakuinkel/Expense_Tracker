<x-guest-layout>
    <div class="p-8 flex items-center justify-center">
        <div class="max-w-lg w-full  rounded-xl">
            <x-heading>
                {{ __('Are you sure you want to edit this category?') }}
            </x-heading>

            <p class="text-gray-600 mt-4 text-sm leading-relaxed">
                Editing this category will permanently edit it from all user records. This action cannot be undone.
            </p>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('category.index') }}"
                   class="inline-flex items-center px-6 py-2.5 bg-[#0ea5e9] hover:bg-[#0e95d9] text-white rounded-lg font-semibold transition-all duration-300 ease-in-out shadow-md hover:shadow-lg">
                    <i class="fas fa-times mr-2"></i> Cancel
                </a>

                @csrf
                <a href="{{ route('category.editCategoryConfirm',$category) }}"
                        class="inline-flex items-center px-6 py-2.5 bg-[#b50e0b] hover:bg-red-700 text-white rounded-lg font-semibold transition-all duration-300 ease-in-out shadow-md hover:shadow-lg">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
