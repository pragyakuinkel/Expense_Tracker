<x-app-layout>

    <x-slot name="header">
        <x-heading>
            {{ __('Dashboard') }}
        </x-heading>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 grid-cols-2 gap-4 align-middle">
                <div class="px-4">
                    <div class="p-6 text-gray-900 bg-white rounded-lg shadow text-center min-h-[200px]">

                        <i class="fas fa-users fa-2x" style="color:#3268a8"></i>

                        <h2 style="color:#293a4e; font-size: 1.4rem; font-weight: bold;">
                            Total number of users
                        </h2>

                        <h1 class="text-xl mt-2">
                            {{$user_count}}
                        </h1>
                    </div>
                </div>
                <div class="px-4">
                    <div class="p-6 text-gray-900 bg-white rounded-lg shadow text-center min-h-[200px]">

                        <i class="fas fa-th-large fa-2x" style="color:#3268a8"></i>

                        <h2 style="color:#293a4e; font-size: 1.4rem; font-weight: bold;">
                            Total number of Categories
                        </h2>

                        <h1 class="text-xl mt-2">
                            {{$category_count}}
                        </h1>
                    </div>
                </div>
                <div class="px-4">
                    <div class="p-6 text-gray-900 bg-white rounded-lg shadow text-center min-h-[200px]">

                        <i class="fas fa-chart-pie fa-2x" style="color:#3268a8"></i>

                        <h2 style="color:#293a4e; font-size: 1.4rem; font-weight: bold;">
                            Category with maximum expense
                        </h2>

                        <h1 class="text-xl mt-2">
                            {{$max_spent->name}}
                        </h1>
                    </div>
                </div>
                <div class="px-4">
                    <div class="p-6 text-gray-900 bg-white rounded-lg shadow text-center min-h-[200px]">

                        <i class="fas fa-dollar-sign fa-2x" style="color:#3268a8"></i>

                        <h2 style="color:#293a4e; font-size: 1.4rem; font-weight: bold;">
                            This Month Average User Income
                        </h2>

                        <h1 class="text-xl mt-2">
                            {{$avg_income}}
                        </h1>
                    </div>
                </div>
            </div>
            <div class="px-4 mt-4">
                <div class="p-6 text-gray-900 bg-white rounded-lg shadow text-center h-full">

                    <h2 style="color:#293a4e; font-size: 1.4rem; font-weight: bold;">
                        Top 5 Categories with Maximum Expense
                    </h2>

                    <div class="space-y-4 mt-4">
                        @foreach($max_spent_categories as $category)
                            <div class="flex justify-between items-center">
                                <div class="text-gray-800 font-semibold">{{ $category->name }}</div>
                                <div class="text-green-600 font-semibold">
                                    Rs. {{ number_format($category->expenses_sum_amount ?? 0, 2) }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
