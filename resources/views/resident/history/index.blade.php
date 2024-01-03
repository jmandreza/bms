<x-app-layout>
    <x-slot name="header">
        <x-header title="Request History" />
    </x-slot>

    <x-section>
        <x-container class="space-y-4">
            <form id="history-search-form" class="flex justify-end" action="{{route('resident.history.search')}}" method="post">
                @csrf
                
                @include('resident.history.filter')
            </form>

            <div class="relative">
                <x-loader id="history-loader" />
                <div id="history-container" class="overflow-x-auto min-h-[3rem]">
                    @include('resident.history.history')
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