<form id="reply-form" action="" method="post" class="max-w-xl grid gap-y-4">
    @method('put')
    @csrf

    <div>
        <x-input-label for="email-field" value="Email" />
        <x-text-input type="email" id="email-field" name="email" class="block mt-1 w-full" :value="old('email')" />
        <x-input-error :messages="$errors->get('email')" data-error="email" />
    </div>

    <div>
        <x-input-label for="subject-field" value="Subject" />
        <x-text-input type="text" id="subject-field" name="subject" class="block mt-1 w-full" :value="old('subject')" />
        <x-input-error :messages="$errors->get('subject')" data-error="email" />
    </div>

    <div>
        <x-input-label for="reply-field" value="Your Reply" />
        <x-textarea id="reply-field" name="reply" class="mt-1">{{old('reply')}}</x-textarea>
        <x-input-error :messages="$errors->get('reply')" data-error="reply" />
    </div>

    <div>
        <x-primary-button type="submit">Send Reply</x-primary-button>
    </div>
</form>

<script type="module">
    $("#reply-form").submit(function(e) {
        e.preventDefault();

        Alert.fire({
            icon: 'info',
            title: 'Send Reply Confirmation',
            text: `Are you sure you want to send this reply to ${$('#email-field').val()}?`,
        }).then((action) => {
            if(action.isConfirmed) {
                Method.submit({
                    form: $(this),
                    modal: $("#reply-form-modal"),
                    edit: false,
                    selected: $(this).find('button[type=submit]'),
                    button: $(this).find('button'),
                    text: ["Sending Reply", "Send Reply"],
                });
            }
        });
    });
</script>