<x-app-layout>
    <x-slot name="header">
        <x-header title="Concerns" />
    </x-slot>

    <x-section>
        <x-container class="space-y-4">
            <form id="concerns-search-form" class="flex flex-col sm:flex-row gap-2 sm:justify-between" action="{{route('admin.concerns.search')}}" method="post">
                @csrf

                <div class="self-center">
                    @include('admin.concerns.filter')
                </div>

                <div class="flex w-full sm:w-2/3 md:w-1/2 gap-x-2">
                    <x-text-input type="text" name="search" id="search-field" placeholder="Search here... " class="w-full" autocomplete="off" />
                    <x-primary-button type="submit">Search</x-primary-button>
                </div>
            </form>

            <div class="relative">
                <x-loader id="concerns-loader" />
                <div id="concerns-container" class="overflow-x-auto min-h-[3rem]">
                    @include('admin.concerns.concerns')
                </div>
            </div>
        </x-container>
    </x-section>

    <x-modal id="reply-form-modal" name="show-reply-form" title="Reply to Concern" :tapToDismiss="false">
        @include('admin.concerns.reply')
    </x-modal>

    <x-modal name="show-concern-preview" containerId="concern-preview-container" title="Concern Details">
        <x-slot name="loader">
            <x-loader id="concern-preview-loader" />
        </x-slot>
    </x-modal>

    <script type="module">
        $("#concerns-search-form").on('submit', function(e) {
            e.preventDefault();

            Method.load({
                form: $(this),
                container: $("#concerns-container"),
                loader: $("#concerns-loader"),
            })
        });
    </script>
</x-app-layout>