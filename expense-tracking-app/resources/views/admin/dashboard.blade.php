<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="px-4 mb-4">
                    <div class="p-6 text-gray-900 bg-white rounded-lg shadow text-center h-full">
                        <x-heading>
                            Total number of users
                        </x-heading>

                        <h1 class="text-xl">
                            {{$user_count}}
                        </h1>
                    </div>
                </div>
                <div class="sm:w-1/2 md:w-1/3 px-4 mb-4">
                    <div class="p-6 text-gray-900 bg-white rounded-lg shadow text-center h-full">
                        <x-heading>
                            Total number of Categories
                        </x-heading>

                        <h1 class="text-xl">
                            {{$category_count}}
                        </h1>
                    </div>
                </div>
                <div class="sm:w-1/2 md:w-1/3 px-4 mb-4">
                    <div class="p-6 text-gray-900 bg-white rounded-lg shadow text-center h-full">
                        <x-heading>
                            Category with maximum expense
                        </x-heading>

                        <h1 class="text-xl">
                            {{$max_spent->name}}
                        </h1>
                    </div>
                </div>
                <div class="sm:w-1/2 md:w-1/3 px-4 mb-4">
                    <div class="p-6 text-gray-900 bg-white rounded-lg shadow text-center h-full">
                        <x-heading>
                            This Month Average User Income
                        </x-heading>

                        <h1 class="text-xl">
                            {{$avg_income}}
                        </h1>
                    </div>
                </div>
                <div class="w-fit sm:w-1/2 md:w-1/3 px-4 mb-4">
                    <div class="p-6 text-gray-900 bg-white rounded-lg shadow text-center h-full">
                        Box 5
                    </div>
                </div>
                <div class="sm:w-1/2 md:w-1/3 px-4 mb-4">
                    <div class="p-6 text-gray-900 bg-white rounded-lg shadow text-center h-full">
                        Box 6
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
