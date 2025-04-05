<nav x-data="{ open: false }" class="border-b bg-white">
    <div class="mx-auto px-2 sm:px-4 lg:px-6">
        <div class="flex items-center justify-between h-16">
            <!-- App Logo -->
            <div class="flex items-center">
{{--                <a href="{{ route('dashboard') }}" class="flex items-center group">--}}
{{--                    <i class="fas fa-coins text-3xl text-[#0ea5e9] mr-3 transition-transform duration-200 group-hover:scale-110"></i>--}}
{{--                </a>--}}

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

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-2">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(Auth::user()->hasPermission('profile.edit', Auth::user()->getRole()->id))
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden -me-2">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-2">
            <!-- Mobile App Logo -->
            <div class="px-2 pb-2">
                <a href="{{ route('dashboard') }}" class="flex items-center group">
                    <i class="fas fa-coins text-2xl text-[#0ea5e9] mr-3 transition-transform duration-200 group-hover:scale-110"></i>
                </a>
            </div>

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if(Auth::user()->hasPermission('expense.index', Auth::user()->getRole()->id))
                <x-responsive-nav-link :href="route('expense.index')" :active="request()->routeIs('expense.index')">
                    {{ __('Expenses') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-2 border-t">
            <div class="px-2 space-y-1">
                <div class="font-medium text-base">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-2 px-2">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

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
