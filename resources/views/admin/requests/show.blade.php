<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Document Requests') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <x-container bg="bg-transparent" padding="sm:px-6 lg:px-8 pt-6">
            <a href="{{url()->previous()}}">
                <x-primary-button>Go Back</x-primary-button>
            </a>
        </x-container>
    </div>

    <x-section class="py-6">
        <x-container id="show-request-container" class="space-y-6">
            @include('admin.requests.show-details')
        </x-container>
    </x-section>

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
                        container: $("#show-request-container"),
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
                        container: $("#show-request-container"),
                        selected: $(this).find('button[type=submit]'),
                        button: $(this).find('button'),
                        text: [headerText, headerText],
                    });
                }
            })
        });
    </script>
</x-app-layout>