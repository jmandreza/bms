<x-table id="requests-table">
    <x-slot name="thead">
        <x-cell type="th">Requester</x-cell>
        <x-cell type="th">Household</x-cell>
        <x-cell type="th">Zone</x-cell>
        <x-cell type="th">Document</x-cell>
        <x-cell type="th">Purpose</x-cell>
        <x-cell type="th">Status</x-cell>
        <x-cell type="th">Date Requested</x-cell>
        <x-cell type="th">Last Modified</x-cell>
        <x-cell type="th">Action</x-cell>
    </x-slot>

    <x-slot name="tbody">
        @forelse($requests as $request)
        <tr>
            <x-cell type="td">{{"{$request->lname}, {$request->fname} ".(isset($request->mname) ? $request->mname[0].'.' : '')}}</x-cell>
            <x-cell type="td">{{$request->household_no}}</x-cell>
            <x-cell type="td">{{$request->zone}}</x-cell>
            <x-cell type="td">{{$request->description}}</x-cell>
            <x-cell type="td">{{Str::limit($request->purpose, 100, '...')}}</x-cell>
            <x-cell type="td">{{$request->status}}</x-cell>
            <x-cell type="td">{{Carbon\Carbon::parse($request->created_at)->format('M d, Y \a\\t h:i A')}}</x-cell>
            <x-cell type="td">{{Carbon\Carbon::parse($request->updated_at)->format('M d, Y \a\\t h:i A')}}</x-cell>
            <x-cell type="td">
                <a href="{{route('admin.history.preview', $request)}}" class="show-history-preview-link" x-data x-on:click.prevent="$dispatch('open-modal', 'show-history-preview')">
                    <x-primary-button>View</x-primary-button>
                </a>
            </x-cell>
        </tr>
        @empty
        <tr>
            <x-cell type="td" colspan="9" class="text-center">No Document Requests found.</x-cell>
        </tr>
        @endforelse
    </x-slot>
</x-table>

<script type="module">
    $(".show-history-preview-link").click(function(e) {
        e.preventDefault();

        Method.load({
            link: $(this).attr('href'),
            container: $("#history-preview-container"),
            loader: $("#history-preview-loader"),
        });
    });
</script>