<x-table id="concerns-table">
    <x-slot name="thead">
        <x-cell type="th">Email</x-cell>
        <x-cell type="th">Subject</x-cell>
        <x-cell type="th">Message</x-cell>
        <x-cell type="th">Date Sent</x-cell>
        <x-cell type="th">Date Replied</x-cell>
        <x-cell type="th">Action</x-cell>
    </x-slot>

    <x-slot name="tbody">
        @forelse($concerns as $concern)
        <tr>
            <x-cell type="td" class="email">{{$concern->email}}</x-cell>
            <x-cell type="td" class="subject">{{$concern->subject}}</x-cell>
            <x-cell type="td">{{Str::limit($concern->message, 100, '...')}}</x-cell>
            <x-cell type="td">{{Carbon\Carbon::parse($concern->created_at)->format('M d, Y \a\\t h:i A')}}</x-cell>
            <x-cell type="td">
                @if(isset($concern->replied_at))
                {{Carbon\Carbon::parse($concern->replied_at)->format('M d, Y \a\\t h:i A')}}
                @endif
            </x-cell>
            <x-cell type="td" align="center">
                <div class="flex gap-x-2">
                    @if(!isset($concern->replied_at))
                    <x-primary-button class="reply-button" :value="route('admin.concerns.update', $concern)" x-data x-on:click="$dispatch('open-modal', 'show-reply-form')">Reply</x-primary-button>
                    @endif

                    <a href="{{route('admin.concerns.preview', $concern)}}" class="concern-preview-link" x-data x-on:click="$dispatch('open-modal', 'show-concern-preview')">
                        <x-secondary-button class="reply-button">Preview</x-secondary-button>
                    </a>
                </div>
                
            </x-cell>
        </tr>
        @empty
        <tr>
            <x-cell type="td" colspan="6" class="text-center">No Concerns sent yet.</x-cell>
        </tr>
        @endforelse
    </x-slot>
</x-table>

<script type="module">
    $(".concern-preview-link").click(function(e) {
        e.preventDefault();

        Method.load({
            link: $(this).attr('href'),
            container: $("#concern-preview-container"),
            loader: $("#concern-preview-loader"),
        });
    });

    $(".reply-button").click(function() {
        let row = $(this).closest('tr');
        let email = row.find('.email').text().trim();
        let subject = row.find('.subject').text().trim();
        let form = $("#reply-form");
        let emailField = form.find('#email-field');
        let subjectField = form.find('#subject-field');

        form.attr('action', $(this).val());
        emailField.val(email);
        subjectField.val(`Re: ${subject}`);
    });
</script>