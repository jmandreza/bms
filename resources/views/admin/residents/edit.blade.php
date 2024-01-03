<form id="edit-resident-form" method="POST" action="{{ route('admin.residents.update', $user) }}" x-data="{activeTab : 1, active: 'border-indigo-400 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out', inactive: 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'}" >
    @method('put')
    @csrf
    
    <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200">
        <!-- Tab -->
        <div class="flex gap-x-2 -mb-px overflow-x-auto">
            <button type="button" class="px-6 py-4 border-b-2 text-sm font-medium leading-5" :class="(activeTab === 1) ? active : inactive" x-data x-on:click.prevent="activeTab = 1">Personal</button>
            <button type="button" class="px-6 py-4 border-b-2 text-sm font-medium leading-5" :class="(activeTab === 2) ? active : inactive" x-data x-on:click.prevent="activeTab = 2">Citizenship</button>
        </div>
    </div>

    <!-- Content -->
    <div x-show="activeTab === 1" class="mt-6 grid sm:grid-cols-2 md:grid-cols-3 gap-4">
        @include('admin.residents.partials.edit-personal-info')
    </div>

    <div x-cloak x-show="activeTab === 2" class="mt-6 grid sm:grid-cols-2 md:grid-cols-3 gap-4">
        @include('admin.residents.partials.edit-citizenship')
    </div>

    <div class="flex items-center justify-end mt-4">
        <div class="flex gap-x-2">
            <x-secondary-button x-cloak x-show="activeTab > 1" x-data x-on:click="activeTab -= 1" class="{activeTab > 1 ? 'block' : 'hidden'}">
                {{ __('Prev') }}
            </x-secondary-button>
            <x-primary-button x-show="activeTab < 2" x-data x-on:click="activeTab += 1" class="{activeTab < 2 ? 'block' : 'hidden'}">
                {{ __('Next') }}
            </x-primary-button>
            <x-primary-button x-cloak type="submit" x-show="activeTab === 2" class="{activeTab === 2 ? 'block' : 'hidden'}">
                {{ __('Save Resident') }}
            </x-primary-button>
        </div>
    </div>
</form>

<script type="module">
    $("#edit-resident-form").on('submit', function(e) {
        e.preventDefault();

        Method.submit({
            form: $(this),
            modal: $("#new-resident-modal"),
            edit: true,
            container: $("#resident-container"),
            selected: $(this).find('button[type=submit]'),
            button: $(this).find('button'),
            text: ['Updating Resident', 'Update Resident'],
        });
    });
</script>