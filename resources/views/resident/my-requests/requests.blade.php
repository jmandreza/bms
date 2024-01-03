<x-table id="requests-table">
    <x-slot name="thead">
        <x-cell type="th">Document</x-cell>
        <x-cell type="th">Purpose</x-cell>
        <x-cell type="th">Status</x-cell>
        <x-cell type="th">Cert ID</x-cell>
        <x-cell type="th">Date Requested</x-cell>
        <x-cell type="th">Last Modified</x-cell>
        <x-cell type="th">Action</x-cell>
    </x-slot>

    <x-slot name="tbody">
        @forelse($requests as $request)
        <tr>
            <x-cell type="td">{{$request->description}}</x-cell>
            <x-cell type="td">{{Str::limit($request->purpose, 100, '...')}}</x-cell>
            <x-cell type="td">{{$request->status}}</x-cell>
            <x-cell type="td">
                @if(isset($request->cert_id))
                    <x-qr-code :key="$request->cert_id" />
                @endif
            </x-cell>
            <x-cell type="td">{{Carbon\Carbon::parse($request->created_at)->format('M d, Y \a\\t h:i A')}}</x-cell>
            <x-cell type="td">{{Carbon\Carbon::parse($request->updated_at)->diffForHumans()}}</x-cell>
            <x-cell type="td" class="flex justify-center">
                <a href="{{route('resident.my-request.preview', $request)}}" class="show-preview-link" x-data x-on:click.prevent="$dispatch('open-modal', 'show-preview')">
                    <x-primary-button id="show-preview-button">Preview</x-primary-button>
                </a>
            </x-cell>
        </tr>
        @empty
        <tr>
            <x-cell colspan="7">No document request found.</x-cell>
        </tr>
        @endforelse
    </x-slot>
</x-table>

<script type="module">
    $(".show-preview-link").click(function(e) {
        e.preventDefault();

        Method.load({
            link: $(this).attr('href'),
            container: $("#preview-container"),
            loader: $("#preview-loader"),
        });
    });
</script>