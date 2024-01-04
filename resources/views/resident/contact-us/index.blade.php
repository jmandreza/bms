<x-app-layout>
    <x-slot name="header">
        <x-header title="Contact Us" />
    </x-slot>

    <x-section>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">

            <x-container class="sm:col-span-2" padding="p-4">
                @include('resident.contact-us.form')
            </x-container>
    </x-section>
</x-app-layout>
