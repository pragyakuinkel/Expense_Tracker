<x-app-layout>
    <x-slot name="header">
        <x-heading>
            {{ __('Assign Permission to ') }} {{$user->name}}
        </x-heading>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex gap-4 mt-3">
                        @foreach($roles as $role)
                            <a href="{{route('admin.permission',$role->id)}}"  style="background-color: #3268a8;color: white"
                               class="px-3 py-2 rounded mb-2">
                                {{$role->name}}
                            </a>
                        @endforeach
                    </div>

                    @if(session('success'))
                        <x-success-message>
                            {{ session('success') }}
                        </x-success-message>
                    @endif


                    <form action="{{route('admin.addPermission')}}" method="POST" class="items-end">
                        @csrf
                        @method('PUT')

                        <input type="hidden" value="{{$user->id}}" name="id">
                        <x-primary-button class="mt-4">Update</x-primary-button>

                        <table class="table-auto border-collapse mt-3 w-full mb-3" style="width: 100%">
                            <thead>
                            <tr style="background-color: #3268a8; color: white">
                                <th class="px-4 py-2 border" style="width: 30%">Group</th>
                                <th class="px-4 py-2 border" style="width: 62%"><input type="checkbox" id="select-all">  Routes Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $group => $groupPermissions)
                                @php $row = count($groupPermissions); @endphp
                                @foreach($groupPermissions as $index => $permission)
                                    <tr>
                                        @if($index === 0)
                                            <td class="border px-4 py-2 font-semibold" rowspan="{{ $row }}">
                                                <input type="checkbox" class="group-checkbox" data-group="{{ $group }}"
                                                    {{ $user->hasPermissionGroup($permission->group, $user->id) ? 'checked' : '' }}>
                                                {{ $group }}
                                            </td>
                                        @endif
                                        <td class="border px-4 py-2">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                   class="permission-checkbox group-{{ $group }}"
                                                {{ $user->hasPermission($permission->name, $user->id) ? 'checked' : '' }}>
                                            {{ $permission->slug }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>


        document.addEventListener("DOMContentLoaded", function () {

            const selectAllRoute = document.getElementById("select-all");
            const groupWiseRoute = document.querySelectorAll(".group-checkbox");
            const permissionRoute = document.querySelectorAll(".permission-checkbox");

            selectAllRoute.addEventListener("change", function (){
                permissionRoute.forEach(checkbox => checkbox.checked = this.checked)
                groupWiseRoute.forEach(checkbox => checkbox.checked = this.checked)
            });

            groupWiseRoute.forEach(groupWiseRoute => {
                groupWiseRoute.addEventListener("change", function (){
                    const groupName = this.dataset.group;
                    const groupPermissions = document.querySelectorAll(`.group-${groupName}`);
                    groupPermissions.forEach(checkbox => checkbox.checked = this.checked);
                });
            });
        });
    </script>
</x-app-layout>
