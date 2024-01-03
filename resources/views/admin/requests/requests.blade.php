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
            <x-cell type="td">{{Carbon\Carbon::parse($request->updated_at)->diffForHumans()}}</x-cell>
            <x-cell type="td">
                <div class="flex justify-center">
                    @if($request->status === App\Enums\StatusEnum::Pending)
                    <div class="flex gap-x-2">
                        <form action="{{route('admin.document-request.update', $request)}}" method="post" class="cancel-request-form">
                            @method('put')
                            @csrf

                            <input type="hidden" name="status" value="{{App\Enums\StatusEnum::Declined}}">
                            <x-danger-button type="submit" :hasLoader="false">Decline</x-danger-button>
                        </form>

                        <form action="{{route('admin.document-request.update', $request)}}" method="post" class="update-request-form">
                            @method('put')
                            @csrf

                            <input type="hidden" name="status" value="{{App\Enums\StatusEnum::Approved}}">
                            <x-primary-button type="submit" :hasLoader="false">Approve</x-primary-button>
                        </form>
                    </div>
                    @elseif($request->status === App\Enums\StatusEnum::Approved)
                        <form action="{{route('admin.document-request.update', $request)}}" method="post" class="update-request-form">
                            @method('put')
                            @csrf

                            <input type="hidden" name="status" value="{{App\Enums\StatusEnum::Ready}}">
                            <x-primary-button type="submit" :hasLoader="false">Ready</x-primary-button>
                        </form>
                    @endif
                </div>
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
    $(".cancel-request-form").on('submit', function(e) {
        e.preventDefault();

        Alert.fire({
            icon: "warning",
            title: "Decline Document Request",
            text: "Are you sure you want to decline this request?",
        }).then((action) => {
            if(action.isConfirmed) {
                Method.submit({
                    form: $(this),
                    edit: false,
                    container: $("#document-request-container"),
                    selected: $(this).find('button[type=submit]'),
                    button: $(this).find('button'),
                    text: ["Decline", "Decline"],
                });
            }
        })
    });

    $(".update-request-form").on('submit', function(e) {
        e.preventDefault();

        let headerText = $.trim($(this).find('button[type=submit]').text());
        Alert.fire({
            icon: "info",
            title: headerText + " Document Request",
            text: "Are you sure you want to " + headerText.toLowerCase() + " this request?",
        }).then((action) => {
            if(action.isConfirmed) {
                Method.submit({
                    form: $(this),
                    edit: false,
                    container: $("#document-request-container"),
                    selected: $(this).find('button[type=submit]'),
                    button: $(this).find('button'),
                    text: [headerText, headerText],
                });
            }
        })
    });
</script>