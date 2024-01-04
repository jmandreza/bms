<x-app-layout>
    <x-slot name="header">
        <x-header title="Request History" />
    </x-slot>

    <x-section>
        <x-container class="space-y-4">
            <form id="history-search-form" class="flex flex-col sm:flex-row gap-2 sm:justify-between" action="{{route('admin.history.search')}}" method="post">
                @csrf
                
                <div class="self-center">
                   @include('admin.history.filter') 
                </div>
                
                <div class="flex w-full sm:w-2/3 md:w-1/2 gap-x-2">
                    <x-text-input type="text" name="search" id="search-field" placeholder="Search here... " class="w-full" autocomplete="off" />
                    <x-primary-button type="submit">Search</x-primary-button>
                </div>
            </form>

            <div class="relative">
                <x-loader id="history-loader" />
                <div id="history-container" class="overflow-x-auto min-h-[3rem]">
                    @include('admin.history.history')
                </div>
            </div>
        </x-container>
    </x-section>

    <x-modal name="show-history-preview" containerId="history-preview-container" title="Request Details">
        <x-slot name="loader">
            <x-loader id="history-preview-loader" />
        </x-slot>
    </x-modal>

    <script type="module">
        $("#history-search-form").on('submit', function(e) {
            e.preventDefault();

            Method.load({
                form: $(this),
                container: $("#history-container"),
                loader: $("#history-loader"),
            })
        });

        $('#scan-code-button').on('click', function(e) {
            let scanner = QrScanner({
                form: $("#update-scanned-code-form"),
                scannerContainer: $("#qr-scanner-container"),
                container: $("#document-request-container"),
                loader: $("#update-scanned-code-loader"),
            });
        });
    </script>
</x-app-layout>