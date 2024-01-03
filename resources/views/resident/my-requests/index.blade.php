<x-app-layout>
    <x-slot name="header">
        <x-header title="My Requests" />
    </x-slot>

    <x-section>
        <x-container class="space-y-4">
            <form id="my-request-search-form" class="flex justify-end" action="{{route('resident.my-request.search')}}" method="post">
                @csrf
                                   
                @include('resident.my-requests.filter')
            </form>

            <div class="relative">
                <x-loader id="requests-loader" />
                <div id="requests-container" class="overflow-x-auto min-h-[3rem]">
                    @include('resident.my-requests.requests')
                </div>
            </div>
        </x-container>
    </x-section>

    <!-- View QR Code in Larger Screen -->
    <x-modal name="show-preview" containerId="preview-container">
        <x-slot name="loader">
            <x-loader id="preview-loader" />
        </x-slot>
    </x-modal>

    <script type="module">
        $("#my-request-search-form").submit(function(e) {
            e.preventDefault();
            
            Method.load({
                form: $(this),
                container: $("#requests-container"),
                loader: $("#requests-loader"),
            });
        });
    </script>
</x-app-layout>
