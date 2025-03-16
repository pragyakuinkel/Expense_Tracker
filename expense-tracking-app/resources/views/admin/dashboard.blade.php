<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 grid-cols-2 gap-4 align-middle">
                <div class="px-4">
                    <div class="p-6 text-gray-900 bg-white rounded-lg shadow text-center h-full">
                        <x-heading>
                            Total number of users
                        </x-heading>

                        <h1 class="text-xl">
                            {{$user_count}}
                        </h1>
                    </div>
                </div>
                <div class="px-4">
                    <div class="p-6 text-gray-900 bg-white rounded-lg shadow text-center h-full">
                        <x-heading>
                            Total number of Categories
                        </x-heading>

                        <h1 class="text-xl">
                            {{$category_count}}
                        </h1>
                    </div>
                </div>
                <div class="px-4">
                    <div class="p-6 text-gray-900 bg-white rounded-lg shadow text-center h-full">
                        <x-heading>
                            Category with maximum expense
                        </x-heading>

                        <h1 class="text-xl">
                            {{$max_spent->name}}
                        </h1>
                    </div>
                </div>
                <div class="px-4">
                    <div class="p-6 text-gray-900 bg-white rounded-lg shadow text-center h-full">
                        <x-heading>
                            This Month Average User Income
                        </x-heading>

                        <h1 class="text-xl">
                            {{$avg_income}}
                        </h1>
                    </div>
                </div>
            </div>
            <div class="px-4 mt-4">
                <div class="p-6 text-gray-900 bg-white rounded-lg shadow text-center h-full">
                    <x-heading>
                        Top 5 Categories with Maximum Expense
                    </x-heading>

                    <div class="space-y-4 mt-4">
                        @foreach($max_spent_categories as $category)
                            <div class="flex justify-between items-center">
                                <div class="text-gray-800 font-semibold">{{ $category->name }}</div>
                                <div class="text-green-600 font-semibold">Rs. {{ number_format($category->expenses_sum_amount ?? 0, 2) }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>
</x-app-layout>
