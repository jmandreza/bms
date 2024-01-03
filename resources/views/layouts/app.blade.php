<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                {{ $header }}
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>

    @if(!Auth::user()->admin)
        @include('layouts.footer')
    @endif

    <script type="module">
        let loader;
        let container;
        let counter;

        $(function() {
            loader = $("#notification-loader");
            container = $("#notification-container");
            counter = $("#notification-counter");

            Push.check();
            loader.show('fast', 'linear');
        });

        Echo.private("notification-channel-{{Auth::id()}}").on("pusher:subscription_succeeded", function(data) {
                // Load Notification
                Method.getNotification({
                    link: "{{ route('unread') }}",
                    container: container,
                    counter: counter,
                });
                loader.hide('fast', 'linear');
            }).listen('.notification-event', function(data) {
                let user;
                // Load Notification
                Method.getNotification({
                    link: "{{ route('unread') }}",
                    container: container,
                    counter: counter,
                });

                if(data.user.username) {
                    user = data.user.username
                }
                else {
                    user = `${data.user.lname}, ${data.user.fname}`;
                }
                
                Push.create({
                    title: "New Notification",
                    message: `${user} ${data.message}`,
                    link: data.link,
                });
            });
    </script>
</html>
