<x-app-layout>
    <x-slot name="header">
        <x-header title="Document Requests" />
    </x-slot>

    <x-section>
        <x-container class="space-y-4">
            <form id="document-request-search-form" class="flex flex-col sm:flex-row gap-2 sm:justify-between" action="{{route('admin.document-request.search')}}" method="post">
                @csrf
                <div class="flex items-center gap-x-2">
                    <x-primary-button id="scan-code-button" x-data x-on:click.prevent="$dispatch('open-modal', 'show-qr-scanner')">Scan Code</x-primary-button>
                    
                    @include('admin.requests.filter')
                </div>
                <div class="flex w-full sm:w-2/3 md:w-1/2 gap-x-2">
                    <x-text-input type="text" name="search" id="search-field" placeholder="Search here... " class="w-full" autocomplete="off" />
                    <x-primary-button type="submit">Search</x-primary-button>
                </div>
            </form>

            <div class="relative">
                <x-loader id="document-request-loader" />
                <div id="document-request-container" class="overflow-x-auto min-h-[3rem]">
                    @include('admin.requests.requests')
                </div>
            </div>
        </x-container>
    </x-section>

    <!-- Qr Code Scanner Modal -->
    <x-modal id="qr-scanner-modal" name="show-qr-scanner" title="Scan Qr Code">
        @include('admin.requests.scanner')
    </x-modal>

    <script type="module">
        $("#document-request-search-form").on('submit', function(e) {
            e.preventDefault();

            Method.load({
                form: $(this),
                container: $("#document-request-container"),
                loader: $("#document-request-loader"),
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
