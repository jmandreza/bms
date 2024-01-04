<x-app-layout>
    <x-slot name="header">
        <x-header title="Profile" />
    </x-slot>
    
    <x-section class="space-y-6">
        @if(!Auth::user()->admin)
        <x-container>
            <div class="max-w-xl">
                @include('profile.partials.update-personal-information-form')
            </div>
        </x-container>
        @endif

        <x-container>
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </x-container>

        <x-container>
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </x-container>

        <x-container>
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </x-container>
    </x-section>
</x-app-layout>
