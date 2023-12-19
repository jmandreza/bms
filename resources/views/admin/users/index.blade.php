<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users Screen') }}
        </h2>
    </x-slot>

    <x-section>
        <x-container class="overflow-x-auto">
            @include('admin.users.users')
        </x-container>
    </x-section>

    {{-- Edit User Modal --}}
    <x-modal name="show-edit-user-form">
        ehe
    </x-modal>
</x-app-layout>
