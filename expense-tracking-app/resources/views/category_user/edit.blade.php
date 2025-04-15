<x-app-layout>
    <div class="py-8">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-heading>
                        {{ __('Edit Category') }}
                    </x-heading>

                    <form action="{{ route('category_user.update', $category->id) }}" method="post">
                        @method('PUT')
                        @csrf

                        <input type="hidden" name="date" value="{{$date}}">

                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Name')"/>
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                          :value="old('name',$category->name)" style="width:100%"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <x-input-label class="block w-full">
                                Limit
                            </x-input-label>
                            <x-text-input type="number" step="any" name="limit" required class="block mt-1 w-full"
                                          :value="old('limit',$category->pivot->limit)"/>
                            <x-input-error :messages="$errors->get('limit')" class="mt-2"/>
                        </div>

                        <div style="color: red">{{$error}}</div>
                        <x-primary-button class="mt-4">Edit</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
