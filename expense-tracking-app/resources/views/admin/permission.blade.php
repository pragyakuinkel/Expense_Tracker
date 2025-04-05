<x-app-layout>
    <x-slot name="header">
        <x-heading class="px-6 py-5 ">
            Assign Permission to  {{ $user->name }}
        </x-heading>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-wrap gap-4 mt-3">
                        @foreach($roles as $role)
                            <a
                                href="{{ route('admin.managePermission', $role->id) }}"
                                class="px-3 py-2 rounded mb-2 text-white hover:bg-cyan-600 transition-colors"
                                style="background-color: #0ea5e9"
                            >
                                {{ $role->name }}
                            </a>
                        @endforeach
                    </div>

                    @if(session('success'))
                        <x-success-message>
                            {{ session('success') }}
                        </x-success-message>
                    @endif

                    <form
                        action="{{ route('admin.addPermission') }}"
                        method="POST"
                    >
                        @csrf
                        @method('PUT')

                        <div class="overflow-x-auto">
                            <table class="table-auto border-collapse w-full mt-3 mb-3">
                                <thead>
                                <tr class="text-white" style="background-color: #0ea5e9">
                                    <th class="px-4 py-2 border w-[30%]">Group</th>
                                    <th class="px-4 py-2 border w-[62%]">
                                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-[#0ea5e9] focus:ring-[#0ea5e9]">
                                        Routes Name
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permissions as $group => $groupPermissions)
                                    @php $row = count($groupPermissions); @endphp
                                    @foreach($groupPermissions as $index => $permission)
                                        <tr class="hover:bg-gray-50">
                                            @if($index === 0)
                                                <td
                                                    class="border px-4 py-2 font-semibold align-top"
                                                    rowspan="{{ $row }}"
                                                >
                                                    <div class="flex items-center gap-2">
                                                        <input
                                                            type="checkbox"
                                                            class="group-checkbox rounded border-gray-300 text-[#0ea5e9] focus:ring-[#0ea5e9]"
                                                            data-group="{{ $group }}"
                                                            {{ $user->hasPermissionGroup($permission->group, $user->id) ? 'checked' : '' }}
                                                        >
                                                        {{ $group }}
                                                    </div>
                                                </td>
                                            @endif
                                            <td class="border px-4 py-2">
                                                <div class="flex items-center gap-2">
                                                    <input
                                                        type="checkbox"
                                                        name="permissions[]"
                                                        value="{{ $permission->id }}"
                                                        class="permission-checkbox group-{{ $group }} rounded border-gray-300 text-[#0ea5e9] focus:ring-[#0ea5e9]"
                                                        {{ $user->hasPermission($permission->name, $user->id) ? 'checked' : '' }}
                                                    >
                                                    {{ $permission->slug }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <input type="hidden" value="{{ $user->id }}" name="id">

                        <x-primary-button>
                            Update
                        </x-primary-button>
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

            selectAllRoute.addEventListener("change", function () {
                permissionRoute.forEach(checkbox => checkbox.checked = this.checked);
                groupWiseRoute.forEach(checkbox => checkbox.checked = this.checked);
            });

            groupWiseRoute.forEach(groupCheckbox => {
                groupCheckbox.addEventListener("change", function () {
                    const groupName = this.dataset.group;
                    const groupPermissions = document.querySelectorAll(`.group-${groupName}`);
                    groupPermissions.forEach(checkbox => checkbox.checked = this.checked);
                });
            });
        });
    </script>
</x-app-layout>
