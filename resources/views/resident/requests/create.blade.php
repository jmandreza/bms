<form id="send-request-form" action="{{route('resident.request.store')}}" method="post" class="grid gap-6">
    @csrf

    <div class="grid gap-4 px-2 max-w-lg">
        <!-- Document Name -->
        <div>
            <x-input-label for="document-id-field" :value="__('Document')" />
            <x-select name="document_id" id="document-id-field" class="mt-1">
                <option value="" selected disabled>Select One</option>
                @foreach($documents as $document)
                <option value="{{$document->id}}">{{$document->description}}</option>
                @endforeach
            </x-select>
            <x-input-error :messages="$errors->get('document_id')" data-error="document_id" class="mt-2" />
        </div>

        <div>
            <x-input-label for="purpose-field" :value="__('Purpose')" />
            <x-textarea id='purpose-field' name='purpose' class="mt-1">{{old('purpose')}}</x-textarea>
            <x-input-error :messages="$errors->get('document_id')" data-error="purpose" class="mt-2" />
        </div>
    </div>
    
    <div class="flex justify-end gap-x-2">
        <x-secondary-button x-data x-on:click.prevent="$dispatch('close')">Close</x-secondary-button>
        <x-primary-button type="submit">Submit</x-primary-button>
    </div>
</form>

<script type="module">
    $('#send-request-form').submit(function(e) {
        e.preventDefault();

        Method.submit({
            form: $(this),
            modal: $("#document-request-modal"),
            edit: false,
            selected: $(this).find('button[type=submit]'),
            button: $(this).find('button'),
            text: ['Submitting', 'Submit'],
        });
    });
</script>