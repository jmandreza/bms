<x-auth-layout>
    <form method="POST" action="{{ route('register') }}" x-data="{activeTab : 1, active: 'border-indigo-400 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out', inactive: 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'}" >
        @csrf
        
        <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
            <!-- Tab -->
            <div class="flex gap-x-2 -mb-px overflow-x-auto">
                <button type="button" class="px-6 py-4 border-b-2 text-sm font-medium leading-5" :class="(activeTab === 1) ? active : inactive" x-data x-on:click.prevent="activeTab = 1">Personal</button>
                <button type="button" class="px-6 py-4 border-b-2 text-sm font-medium leading-5" :class="(activeTab === 2) ? active : inactive" x-data x-on:click.prevent="activeTab = 2">Citizenship</button>
                <button type="button" class="px-6 py-4 border-b-2 text-sm font-medium leading-5" :class="(activeTab === 3) ? active : inactive" x-data x-on:click.prevent="activeTab = 3">Account</button>
            </div>
        </div>

        <!-- Content -->
        <div x-show="activeTab === 1" class="mt-6 space-y-4">
            @include('auth.partials.personal-info')
        </div>

        <div x-cloak x-show="activeTab === 2" class="mt-6 space-y-4">
            @include('auth.partials.citizenship')
        </div>

        <div x-cloak x-show="activeTab === 3" class="mt-6 space-y-4">
            @include('auth.partials.account')
        </div>

        <div>
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>

        <div class="flex items-center justify-end mt-4">
            <div class="flex gap-x-2">
                <x-secondary-button x-show="activeTab > 1" x-data x-on:click="activeTab -= 1" class="{activeTab > 1 ? 'block' : 'hidden'}">
                    {{ __('Prev') }}
                </x-secondary-button>
                <x-primary-button x-cloak x-show="activeTab < 3" x-data x-on:click="activeTab += 1" class="{activeTab < 3 ? 'block' : 'hidden'}">
                    {{ __('Next') }}
                </x-primary-button>
                <x-primary-button x-cloak type="submit" x-show="activeTab === 3" class="{activeTab === 3 ? 'block' : 'hidden'}">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-auth-layout>
