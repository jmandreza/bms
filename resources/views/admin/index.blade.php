<x-app-layout>
    <x-slot name="header">
        <x-header title="Dashboard" />
    </x-slot>

    <x-section>
        <x-container class="grid sm:grid-cols-2 md:col-span-3 lg:grid-cols-4 gap-4" bg="bg-transparent" padding="px-2 sm:px-0">

            <!-- Document Request Canvas -->
            <div class="space-y-2 sm:col-span-2 lg:col-span-3 bg-white overflow-x-auto rounded-lg p-4">
                <div class="flex justify-between items-center">
                    <p class="text-xl text-gray-800 font-semibold">Document Requests</p>
                    <x-link :href="route('admin.residents.index')">View More ></x-link>
                </div>

                <form id="filter-request-date-form" action="{{route('admin.filter-statistics')}}" method="post" class="flex flex-col sm:flex-row sm:justify-end gap-2">
                    @csrf

                    <div>
                        <x-input-label for="date-from-field" value="Starting Date" />
                        <x-text-input type="date" id="date-from-field" name="date_from" :value="Carbon\Carbon::now()->subDays(13)->format('Y-m-d')" class="w-full sm:w-auto" />
                    </div>
                    <div>
                        <x-input-label for="date-to-field" value="End Date" />
                        <x-text-input type="date" id="date-to-field" name="date_to" :value="Carbon\Carbon::now()->format('Y-m-d')" class="w-full sm:w-auto" />
                    </div>

                    <div class="flex justify-end sm:justify-start gap-x-2">
                        <x-primary-button type="submit" class="self-end">Filter</x-primary-button>
                        <x-danger-button id="reset-button" class="self-end">Reset</x-danger-button>
                    </div>
                </form>

                <div class="w-full h-96 sm:h-72 max-h-96 sm:max-h-72">
                    <canvas id="request-canvas"></canvas>
                </div>
            </div>

            <!-- Request Status Canvas -->
            <div class="space-y-2 bg-white rounded-lg p-4">
                <div>
                    <p class="text-xl text-gray-800 font-semibold leading-none">Requests</p>
                    <x-link :href="route('admin.residents.index')">View More ></x-link>
                </div>                
                
                <div class="mx-auto w-2/3 sm:w-4/5 lg:w-full">
                    <canvas id="request-status-canvas"></canvas>
                </div>
            </div>

            <!-- Gender Canvas -->
            <div class="space-y-2 bg-white rounded-lg p-4">
                <div>
                    <p class="text-xl text-gray-800 font-semibold leading-none">Gender</p>
                    <x-link :href="route('admin.residents.index')">View More ></x-link>
                </div>

                <div class="mx-auto w-2/3 sm:w-4/5 lg:w-full">
                    <canvas id="gender-canvas"></canvas>
                </div>
            </div>

            <!-- 4ps Member Canvas -->
            <div class="space-y-2 bg-white rounded-lg p-4">
                <div>
                    <p class="text-xl text-gray-800 font-semibold leading-none">4Ps Member</p>
                    <x-link :href="route('admin.residents.index')">View More ></x-link>
                </div>

                <div class="mx-auto w-2/3 sm:w-4/5 lg:w-full">
                    <canvas id="fourps-member-canvas"></canvas>
                </div>
            </div>

            <!-- Full Vaccination Canvas -->
            <div class="space-y-2 bg-white rounded-lg p-4">
                <div>
                    <p class="text-xl text-gray-800 font-semibold leading-none">Fully Vaccinated</p>
                    <x-link :href="route('admin.residents.index')">View More ></x-link>
                </div>

                <div class="mx-auto w-2/3 sm:w-4/5 lg:w-full">
                    <canvas id="fully-vaxxed-canvas"></canvas>
                </div>
            </div>

            <!-- Voters Canvas -->
            <div class="space-y-2 bg-white rounded-lg p-4">
                <div>
                    <p class="text-xl text-gray-800 font-semibold leading-none">Voter</p>
                    <x-link :href="route('admin.residents.index')">View More ></x-link>
                </div>

                <div class="mx-auto w-2/3 sm:w-4/5 lg:w-full">
                    <canvas id="voter-canvas"></canvas>
                </div>
            </div>
        </x-container>
    </x-section>

    <script type="module">
        var requestCanvas;
        var statusCanvas;
        var genderCanvas;
        var fourpsCanvas;
        var fullyVaxxedCanvas;
        var voterCanvas;

        $(function() {
            // Fetch Statistics
            $.get('{!! route("admin.get-statistics") !!}', function(data, status) {
                if(data.success) {
                    // Load Document Requests Chart
                    requestCanvas = Chart({
                        canvas: $("#request-canvas"),
                        dataset: data.requests,
                        type: 'line',
                        label: "Requests",
                    });

                    // Load Request Status Chart
                    statusCanvas = Chart({
                        canvas: $("#request-status-canvas"),
                        dataset: data.status,
                        type: 'doughnut',
                        label: "Request Status",
                    });

                    // Load Gender Chart
                    genderCanvas = Chart({
                        canvas: $("#gender-canvas"),
                        dataset: data.gender,
                        type: 'doughnut',
                        label: "Gender",
                    });

                    // Load 4PS Member Chart
                    fourpsCanvas = Chart({
                        canvas: $("#fourps-member-canvas"),
                        dataset: data.fourps,
                        type: 'doughnut',
                        label: "4PS Member",
                    });

                    // Load Fully Vaccinated Chart
                    fullyVaxxedCanvas = Chart({
                        canvas: $("#fully-vaxxed-canvas"),
                        dataset: data.fullyVaxxed,
                        type: 'doughnut',
                        label: "Fully Vaccinated",
                    });

                    // Load Voter Chart
                    voterCanvas = Chart({
                        canvas: $("#voter-canvas"),
                        dataset: data.voter,
                        type: 'doughnut',
                        title: "Voters",
                        label: "Voter",
                    });
                }
            });
        });

        // Filter Document Requests Chart
        $("#filter-request-date-form").on('submit', function(e) {
            e.preventDefault();

            $.post($(this).attr('action'), $(this).serializeArray(), function(data, status) {
                requestCanvas.destroy();

                requestCanvas = Chart({
                    canvas: $("#request-canvas"),
                    dataset: data.requests,
                    type: 'line',
                    label: "Requests",
                });
            }).fail(function(xhr, status, error) {
                Toast.fire({
                    icon: 'error', 
                    text: `Error excuting request. Reason: ${error}. Please try again.`
                });
            });
        });

        // Reset Document Request Chart
        $('button#reset-button').click(function() {
            let form = $("#filter-request-date-form");
            form.get(0).reset();
            form.triggerHandler('submit');
        });
    </script>
</x-app-layout>
