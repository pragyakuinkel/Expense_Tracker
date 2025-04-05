<x-guest-layout>
    <div class="p-6">

        <x-heading>
            {{ __('Select Role') }}
        </x-heading>

        <div>
            <form action="{{route('user_role.assignRoleSelect')}}" method="post">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Role')"/>
                    <select name="role" required
                            class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#3268a8] focus:border-[#3268a8]"
                            style="width:100%">
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
                <x-primary-button type="submit" class="mt-4">Next</x-primary-button>
            </form>
        </div>
    </div>
</x-guest-layout>
