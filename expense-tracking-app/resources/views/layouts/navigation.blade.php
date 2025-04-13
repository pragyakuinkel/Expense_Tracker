
<nav x-data="{ open: false }" class="border-b bg-[#0ea5e9] text-white">
    <div class="mx-auto px-2 sm:px-4 lg:px-6">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <div class="flex items-center gap-3">
                    <svg class="w-8 h-8" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="25" y="25" width="50" height="50" rx="10" fill="white" fill-opacity="0.2"/>
                        <path d="M50 20V30M50 70V80" stroke="white" stroke-width="4" stroke-linecap="round"/>
                        <path d="M40 40L60 60M60 40L40 60" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    </svg>
                    <h1 class="text-xl">Expense Tracker</h1>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center space-x-6 sm:ms-6">
                    @if(Auth::user()->roles()->first()->name === 'superAdmin' || Auth::user()->hasPermission('admin.dashboard', Auth::user()->getRole()->id))
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->roles()->first()->name === 'superAdmin' || Auth::user()->hasPermission('category.index', Auth::user()->getRole()->id))
                        <x-nav-link :href="route('category.index')" :active="request()->routeIs('category.index')">
                            {{ __('Manage Category') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->roles()->first()->name === 'superAdmin' || Auth::user()->hasPermission('admin.user', Auth::user()->getRole()->id))
                        <x-nav-link :href="route('admin.manageUser')" :active="request()->routeIs('admin.manageUser')">
                            {{ __('Manage User') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->roles()->first()->name === 'superAdmin' || Auth::user()->hasPermission('admin.permission', Auth::user()->getRole()->id))
                        <x-nav-link :href="route('admin.managePermission')" :active="request()->routeIs('admin.managePermission')">
                            {{ __('Permissions') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->roles()->first()->name === 'superAdmin' || Auth::user()->hasPermission('role', Auth::user()->getRole()->id))
                        <x-nav-link :href="route('role.index')" :active="request()->routeIs('role.index')">
                            {{ __('Roles') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->roles()->first()->name != 'superAdmin')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Home') }}
                        </x-nav-link>

                        <x-nav-link :href="route('expense.index')" :active="request()->routeIs('expense.index')">
                            {{ __('Expenses') }}
                        </x-nav-link>

                        <x-nav-link :href="route('income.index')" :active="request()->routeIs('income.index')">
                            {{ __('Incomes') }}
                        </x-nav-link>

                        <x-nav-link :href="route('category_user.monthlyCategory')" :active="request()->routeIs('category_user.monthlyCategory')">
                            {{ __('Categories') }}
                        </x-nav-link>

                        <x-nav-link :href="route('forecast.forecast')" :active="request()->routeIs('forecast.forecast')">
                            {{ __('Forecast') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition duration-150 ease-in-out text-white">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-2">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="white">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex items-center sm:hidden -me-2">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="white" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden border-t">
        <div class="pt-2 pb-3 space-y-2">

            <x-responsive-nav-link :href="route('profile.edit')">
                {{ __('Profile') }}
            </x-responsive-nav-link>

            @if(Auth::user()->roles()->first()->name === 'superAdmin' || Auth::user()->hasPermission('admin.dashboard', Auth::user()->getRole()->id))
                <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
            @endif

            @if(Auth::user()->roles()->first()->name === 'superAdmin' || Auth::user()->hasPermission('category.index', Auth::user()->getRole()->id))
                <x-responsive-nav-link  :href="route('category.index')">
                    {{ __('Manage Category') }}
                </x-responsive-nav-link >
            @endif

            @if(Auth::user()->roles()->first()->name === 'superAdmin' || Auth::user()->hasPermission('admin.user', Auth::user()->getRole()->id))
                <x-responsive-nav-link  :href="route('admin.manageUser')">
                    {{ __('Manage User') }}
                </x-responsive-nav-link >
            @endif

            @if(Auth::user()->roles()->first()->name === 'superAdmin' || Auth::user()->hasPermission('admin.permission', Auth::user()->getRole()->id))
                <x-responsive-nav-link  :href="route('admin.managePermission')">
                    {{ __('Permissions') }}
                </x-responsive-nav-link >
            @endif

            @if(Auth::user()->roles()->first()->name === 'superAdmin' || Auth::user()->hasPermission('role', Auth::user()->getRole()->id))
                <x-responsive-nav-link  :href="route('role.index')">
                    {{ __('Roles') }}
                </x-responsive-nav-link >
            @endif

            @if(Auth::user()->roles()->first()->name != 'superAdmin')
                <x-responsive-nav-link :href="route('dashboard')">
                    {{ __('Home') }}
                </x-responsive-nav-link >

                <x-responsive-nav-link  :href="route('expense.index')">
                    {{ __('Expenses') }}
                </x-responsive-nav-link >

                <x-responsive-nav-link :href="route('income.index')">
                    {{ __('Incomes') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link  :href="route('category_user.monthlyCategory')">
                    {{ __('Categories') }}
                </x-responsive-nav-link >

                <x-responsive-nav-link  :href="route('forecast.forecast')">
                    {{ __('Forecast') }}
                </x-responsive-nav-link >
            @endif
        </div>

        <div class="pt-4 pb-2 border-t">
            <div class="px-2 space-y-1">
                <div class="font-medium text-base">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-2 px-2">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
