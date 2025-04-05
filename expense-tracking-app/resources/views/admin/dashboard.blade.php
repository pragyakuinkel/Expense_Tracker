<x-app-layout>
    <x-slot name="header">
        <div class="px-6 py-5" >
            <x-heading>
                {{ __('Dashboard') }}
            </x-heading>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- User Count Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center min-h-[200px] flex flex-col justify-center transition-all duration-300 hover:shadow-xl">
                    <i class="fas fa-users fa-2x text-[#0ea5e9] mb-4"></i>
                    <h2 class="text-lg font-bold text-gray-800">
                        Total Number of Users
                    </h2>
                    <h1 class="text-2xl mt-2 text-gray-900 font-semibold">
                        {{ $user_count }}
                    </h1>
                </div>

                <!-- Category Count Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center min-h-[200px] flex flex-col justify-center transition-all duration-300 hover:shadow-xl">
                    <i class="fas fa-th-large fa-2x text-[#0ea5e9] mb-4"></i>
                    <h2 class="text-lg font-bold text-gray-800">
                        Total Number of Categories
                    </h2>
                    <h1 class="text-2xl mt-2 text-gray-900 font-semibold">
                        {{ $category_count }}
                    </h1>
                </div>

                <!-- Max Spent Category Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center min-h-[200px] flex flex-col justify-center transition-all duration-300 hover:shadow-xl">
                    <i class="fas fa-chart-pie fa-2x text-[#0ea5e9] mb-4"></i>
                    <h2 class="text-lg font-bold text-gray-800">
                        Category with Maximum Expense
                    </h2>
                    <h1 class="text-2xl mt-2 text-gray-900 font-semibold">
                        {{ $max_spent->name }}
                    </h1>
                </div>

                <!-- Average Income Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center min-h-[200px] flex flex-col justify-center transition-all duration-300 hover:shadow-xl">
                    <i class="fas fa-dollar-sign fa-2x text-[#0ea5e9] mb-4"></i>
                    <h2 class="text-lg font-bold text-gray-800">
                        This Month Average User Income
                    </h2>
                    <h1 class="text-2xl mt-2 text-gray-900 font-semibold">
                        Rs. {{ number_format($avg_income, 2) }}
                    </h1>
                </div>
            </div>

            <!-- Top 5 Categories Card -->
            <div class="mt-6">
                <div class="bg-white rounded-xl shadow-lg p-6 text-gray-900">
                    <h2 class="text-lg font-bold text-gray-800 text-center">
                        Top 5 Categories with Maximum Expense
                    </h2>
                    <div class="space-y-4 mt-6">
                        @foreach($max_spent_categories as $category)
                            <div class="flex justify-between items-center px-4 py-2 bg-gray-50 rounded-lg transition-all duration-200 hover:bg-gray-100">
                                <span class="text-gray-800 font-semibold">{{ $category->name }}</span>
                                <span class="text-green-600 font-semibold">Rs. {{ number_format($category->expenses_sum_amount ?? 0, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
