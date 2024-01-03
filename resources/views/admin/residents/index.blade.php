<x-app-layout>
    <x-slot name="header">
        <x-header title="Residents" />
    </x-slot>

    <x-section>
        <x-container class="space-y-4">
            <form id="search-form" class="flex flex-col sm:flex-row gap-2 sm:justify-between" action="{{route('admin.residents.search')}}" method="post">
                @csrf

                <div class="flex items-center gap-x-2">
                    <x-primary-button id="scan-code-button" x-data x-on:click.prevent="$dispatch('open-modal', 'show-new-resident-form')">Add Resident</x-primary-button>
                </div>

                <div class="flex w-full sm:w-2/3 md:w-1/2 gap-x-2">
                    <x-text-input type="text" name="search" id="search-field" placeholder="Search here... " class="w-full" />
                    <x-primary-button type="submit">Search</x-primary-button>
                </div>
            </form>

            <div class="relative">
                <x-loader id="resident-loader" />

                <div id="resident-container" class="overflow-x-auto min-h-[3rem]">
                    @include('admin.residents.residents')
                </div>
            </div>
            
        </x-container>
    </x-section>

    <!-- Add Resident Modal-->
    <x-modal id="new-resident-modal" name="show-new-resident-form" title="Add New Resident">
        @include('admin.residents.create')
    </x-modal>

    <!-- Edit Resident Modal -->
    <x-modal id="edit-resident-modal" name="show-edit-resident-form" containerId="edit-resident-container" title="Edit Resident">
        <x-slot name="loader">
            <x-loader id="edit-resident-loader" />
        </x-slot>
    </x-modal>

    <script type="module">
        $("#search-form").on('submit', function(e) {
            e.preventDefault();

            Method.load({
                form: $(this),
                container: $("#resident-container"),
                loader: $("#resident-loader"),
            })
        });
    </script>
</x-app-layout>
