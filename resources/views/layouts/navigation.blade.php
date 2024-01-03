<nav x-data="{ open: false }" class="sticky top-0 bg-white border-b border-gray-100 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex">
                    <!-- Admin Route -->
                    @if(Auth::user()?->admin ?? false)
                        <x-nav-link :href="url('/')" :active="request()->routeIs('admin.home')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.document-request.index')" :active="request()->routeIs('admin.document-request.*')">
                            {{ __('Requests') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.residents.index')" :active="request()->routeIs('admin.residents.*')">
                            {{ __('Residents') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.history.index')" :active="request()->routeIs('admin.history.*')">
                            {{ __('History') }}
                        </x-nav-link>

                    <!-- Resident/Guest route -->
                    @else
                        <x-nav-link :href="url('/')" :active="request()->routeIs('resident.home') || request()->routeIs('guest.home')">
                            {{ __('Home') }}
                        </x-nav-link>
                        <x-nav-link :href="route('resident.request.index')" :active="request()->routeIs('resident.request.*')">
                            {{ __('Request Document') }}
                        </x-nav-link>
                        @if(Auth::check())
                            <x-nav-link :href="route('resident.my-request.index')" :active="request()->routeIs('resident.my-request.*')">
                                {{ __('My Requests') }}
                            </x-nav-link>

                            <x-nav-link :href="route('resident.history.index')" :active="request()->routeIs('resident.history.*')">
                                {{ __('History') }}
                            </x-nav-link>
                            
                            <x-nav-link :href="route('resident.contact-us.index')" :active="request()->routeIs('resident.contact-us.*')">
                                {{ __('Contact Us') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('guest.contact-us.index')" :active="request()->routeIs('guest.contact-us.*')">
                                {{ __('Contact Us') }}
                            </x-nav-link>
                        @endif
                    @endif
                </div>
            </div>

            <div class="flex gap-x-4">
                @if(Auth::check())
                <!-- Notification -->
                <div class="flex items-center">
                    <x-notification />
                </div>

                <!-- Settings Dropdown -->
                <div class="hidden md:flex md:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->username }}</div>

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
            
            
                @else
                <div class="hidden space-x-8 md:ms-10 md:flex">
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Login') }}
                    </x-nav-link>

                    <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Register') }}
                    </x-nav-link>
                </div>
                @endif

                <!-- Hamburger -->
                <div class="-me-2 flex items-center md:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-cloak 
        x-show="open"
        x-on:click.outside="open = false"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed max-h-[calc(100%-4rem)] w-full overflow-y-auto bg-white shadow-md">

        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()?->admin ?? false)
                <x-responsive-nav-link :href="url('/')" :active="request()->routeIs('admin.home')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.document-request.index')" :active="request()->routeIs('admin.document-request.*')">
                    {{ __('Requests') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.residents.index')" :active="request()->routeIs('admin.residents.*')">
                    {{ __('Residents') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.history.index')" :active="request()->routeIs('admin.history.*')">
                    {{ __('History') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="url('/')" :active="request()->routeIs('resident.home') || request()->routeIs('guest.home')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('resident.request.index')" :active="request()->routeIs('resident.request.*')">
                    {{ __('Request Document') }}
                </x-responsive-nav-link>
                @if(Auth::check())
                    <x-responsive-nav-link :href="route('resident.my-request.index')" :active="request()->routeIs('resident.my-request.*')">
                        {{ __('My Requests') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('resident.history.index')" :active="request()->routeIs('resident.history.*')">
                        {{ __('History') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('resident.contact-us.index')" :active="request()->routeIs('guest.contact-us.*') || request()->routeIs('resident.contact-us.*')">
                        {{ __('Contact Us') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('resident.contact-us.index')" :active="request()->routeIs('guest.contact-us.*') || request()->routeIs('resident.contact-us.*')">
                        {{ __('Contact Us') }}
                    </x-responsive-nav-link>
                @endif
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @if(Auth::check())
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->username }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            
            @else
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">Guest User</div>
                <div class="font-medium text-sm text-gray-500">You are not logged in</div>
            </div>
            
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                    {{ __('Register') }}
                </x-responsive-nav-link>
            </div>
            @endif
        </div>
    </div>
</nav>
