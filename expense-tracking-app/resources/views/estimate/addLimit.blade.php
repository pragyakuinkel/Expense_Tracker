<x-guest-layout>
    <div class="p-6">
        <x-heading>
            {{ __('Add Limit') }}
        </x-heading>

        <div class="mt-4 w-full">
            <form action="{{route('estimate.addLimit')}}" method="post">
                @csrf

                @foreach($categories as $category)
                    <div>
                        <x-input-label class="block w-full">
                            {{ $category }}
                        </x-input-label>
                        <x-text-input type="hidden" step="any" name="categories[]" value="{{$category}}"/>
                        <x-text-input type="number" min="0" max="100" step="any" name="limits[]" required class="block mt-1 w-full"
                                      style="width:100%"/>
                    </div>
                @endforeach

                @foreach($new_categories as $category)
                    <div class="mt-4">
                        <x-input-label class="block w-full">
                            {{ $category }}
                        </x-input-label>
                        <x-text-input type="hidden" step="any" name="new_categories[]" value="{{$category}}"/>
                        <x-text-input type="number" step="any" name="new_limits[]" class="block mt-1 w-full" required
                                      style="width:100%"/>
                    </div>
                @endforeach

                <x-input-error :messages="session()->get('error')" class="mt-2"/>

                <x-primary-button type="submit" class="mt-4">Add</x-primary-button>
            </form>
        </div>
    </div>
</x-guest-layout>
