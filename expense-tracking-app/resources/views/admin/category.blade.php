<x-app-layout>
    <x-slot name="header">
        <div class="flex row justify-between">
            <x-heading>
                {{"User Added Category"}}
            </x-heading>
        </div>
    </x-slot>

    <div class="py-12 w-fit">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-heading>{{$user->name}}</x-heading>
                    @foreach ($categories as $month => $allCategories)
                        <h3 class="mt-2 text-xl"><b>{{ $month }}</b></h3>
                        @forelse($allCategories as $category)
                            <div class="flex row justify-between mt-3">
                                <div class="font-medium">
                                    {{$category->name}}
                                </div>
                            </div>
                        @empty
                                <x-empty-value>
                                    No Categories Yet....
                                </x-empty-value>
                        @endforelse
                        <hr>
                    @endforeach

            </div>
        </div>
    </div>
</x-app-layout>
