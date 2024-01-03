<x-app-layout>
    <x-slot name="header">
        <x-header title="Request Document" />
    </x-slot>

    <x-section>
        <x-container class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 shadow-none" bg="bg-transparent" padding="p-0">
            @foreach($documents as $document)
                <div class="p-6">
                    <p class="text-xl">{{$document->description}}</p>

                    <x-primary-button class="request-this-button" value="{{$document->id}}" x-data x-on:click.prevent="$dispatch('open-modal', 'show-document-request-form')">Request</x-primary-button>
                </div>
            @endforeach
        </x-container>
    </x-section>

    <x-modal id="document-request-modal" name='show-document-request-form' title="Request Document" containerId='document-request-container'>
        @include('resident.requests.create')
    </x-modal>

    <script type="module">
        $('.request-this-button').click(function() {
            let selected = $(this).val();
            $("#document-id-field option[value=" + selected + "]").prop('selected', true);
        });

        $("#test-button").click(function(e) {
            Method.toggleButton({
                button: $(this),
                selected: $(this),
                enabled: true,
                text: 'Testing Button',
            });
            Push.create({
                title: 'New Notification',
                message: 'eme langs',
            })
            setTimeout(() => {
                Method.toggleButton({
                    button: $(this),
                    selected: $(this),
                    enabled: false,
                    text: 'Test Button',
                });
            }, 5000);
        });
    </script>
</x-app-layout>
