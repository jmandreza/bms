<form id="contact-us-form" action="{{route('guest.contact-us.store')}}" method="post" class="max-w-xl grid gap-y-4">
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
        <x-input-label for="message-field" value="Message" />
        <x-textarea id="message-field" name="message" class="mt-1">{{old('message')}}</x-textarea>
        <x-input-error :messages="$errors->get('message')" data-error="message" />
    </div>

    <div>
        <x-primary-button type="submit">Submit</x-primary-button>
    </div>
</form>

<script type="module">
    $("#contact-us-form").submit(function(e) {
        e.preventDefault();

        Alert.fire({
            icon: 'info',
            title: 'Submit Confirmation',
            text: 'Are you sure you want to send this to the administration?',
        }).then((action) => {
            if(action.isConfirmed) {
                Method.submit({
                    form: $(this),
                    edit: false,
                    selected: $(this).find('button[type=submit]'),
                    button: $(this).find('button'),
                    text: ["Submitting", "Submit"],
                });
            }
        });
    });
</script>