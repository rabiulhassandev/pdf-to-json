<div class="h-full flex flex-col justify-between">
    <div>
        <!-- Logo -->
        <div class="p-4 flex items-center">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </a>
        </div>

        <!-- Navigation Links -->
        <nav class="mt-5 space-y-1">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="block w-full text-left">
                {{ __('Dashboard') }}
            </x-nav-link>
            <x-nav-link :href="route('customers')" :active="request()->routeIs('customers')" class="block w-full text-left">
                {{ __('Customers') }}
            </x-nav-link>
            <x-nav-link :href="route('process.document')" :active="request()->routeIs('process.document')" class="block w-full text-left">
                {{ __('Process Document') }}
            </x-nav-link>
        </nav>
    </div>

    <!-- User Dropdown -->
    <div class="p-4">
        <x-dropdown align="top" width="48">
            <x-slot name="trigger">
                <button class="flex items-center w-full text-left px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-slate-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                    <div>{{ Auth::user()->name }}</div>
                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                                     onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</div>


