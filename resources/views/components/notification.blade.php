<div x-data="{ notifOpen: false }" class="md:relative">
    <div class="relative">
        <span id="notification-counter" class="hidden absolute top-0 right-0 bg-red-600 text-white text-xs leading-none font-medium px-1 py-0.5 rounded-full">0</span>

        <button type="button" id="notification-bell-icon" @click="notifOpen = !notifOpen" class="m-2 py-auto">
            <svg class="w-6 h-6 stroke-gray-500 hover:stroke-gray-700" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9.0003 21H15.0003M18.0003 8.6C18.0003 7.11479 17.3682 5.69041 16.2429 4.6402C15.1177 3.59 13.5916 3 12.0003 3C10.409 3 8.88288 3.59 7.75766 4.6402C6.63245 5.69041 6.0003 7.11479 6.0003 8.6C6.0003 11.2862 5.32411 13.1835 4.52776 14.4866C3.75646 15.7486 3.37082 16.3797 3.38515 16.5436C3.40126 16.7277 3.4376 16.7925 3.58633 16.9023C3.71872 17 4.34793 17 5.60636 17H18.3943C19.6527 17 20.2819 17 20.4143 16.9023C20.563 16.7925 20.5994 16.7277 20.6155 16.5436C20.6298 16.3797 20.2441 15.7486 19.4729 14.4866C18.6765 13.1835 18.0003 11.2862 18.0003 8.6Z" stroke="currentStroke" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
        </button>
    </div>
    <div class="fixed md:absolute w-screen max-w-md right-0 px-4 md:px-0">
        <div x-cloak x-show="notifOpen"
            x-on:click.outside="notifOpen = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4" 
            class="w-full py-3 space-y-3 bg-white rounded-md ring-1 ring-black ring-opacity-5 shadow-lg overflow-y-hidden z-20 transition-all duration-300">
            <div class="px-4">
                <p class="text-lg font-semibold"> Notifications </p>
            </div>
            <div id="notification-container" class="relative max-h-48 md:max-h-96 py-1 overflow-y-auto divide-y">
                <div id="notification-loader" class="hidden text-center">Fetching Notifications...</div>
            </div>
            <div class="px-4 text-right">
                <form id="mark-all-as-read" action="{{route('mark-all-as-read')}}" method="post">
                    @csrf

                    <button type=submit class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Mark All as Read</button>
                </form>
            </div>
        </div>
    </div>
</div> 

<script type="module">
    // Notification Methods
    $("#mark-all-as-read").on("submit", function(e) {
        e.preventDefault();

        Method.load({
            form: $(this),
            container: $("#notification-container"),
            counter: $("#notification-counter"),
        })
    });
</script>