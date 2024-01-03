<x-app-layout>
    <x-slot name="header">
        <x-header title="Request Details" />
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <x-container bg="bg-transparent" padding="px-2 sm:px-6 lg:px-8 pt-6">
            <a href="{{url()->previous()}}">
                <x-primary-button>Go Back</x-primary-button>
            </a>
        </x-container>
    </div>

    <x-section class="py-6">
        <x-container class="space-y-4">
            <div class="max-w-xl">
                <div class="flex justify-center sm:justify-start p-2">
                    @if(isset($request->cert_id))
                    <x-qr-code :size="256" :key="$request->cert_id" />
                    @else
                    <div class="flex justify-center items-center border-2 border-gray-800 w-64 h-64">
                        <p class="italic">No Cert ID issued yet</p>
                    </div>
                    @endif
                </div>

                <table>
                    <tr>
                        <td class="font-semibold">Document</td>
                        <td class="py-1 pl-4">{{$request->document->description}}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Purpose</td>
                        <td class="py-1 pl-4">{{$request->purpose}}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Status</td>
                        <td class="py-1 pl-4">{{$request->status}}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Date Rquested</td>
                        <td class="py-1 pl-4">{{Carbon\Carbon::parse($request->created_at)->format('F d, Y \a\\t h:i A')}}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Last Modified</td>
                        <td class="py-1 pl-4">{{Carbon\Carbon::parse($request->updated_at)->format('F d, Y \a\\t h:i A')}}</td>
                    </tr>
                </table>
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