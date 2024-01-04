<x-filter align="left">
    <x-slot name="trigger">
        <x-secondary-button>
            <p>Filter</p>

            <div class="ms-1">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
        </x-secondary-button>
    </x-slot>

    <x-slot name="content">
        <p class="p-2 text-xs text-gray-800 font-bold uppercase leading-none">Filter by Document</p>
        <div class="px-4 py-2">
            <x-input-label for="document-filter-field" value="Document" />
            <x-select id="document-filter-field" name="document_filter" class="mt-1">
                <option value="">All Documents</option>
                @foreach($documents as $document)
                <option value="{{$document->description}}">{{$document->description}}</option>
                @endforeach
            </x-select>
        </div>
        
        <p class="p-2 text-xs text-gray-800 font-bold uppercase leading-none">Filter by Status</p>
        <ul class="text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioButton">
            <li class="hover:bg-gray-100">
                <x-input-label for="status-filter-none" class="flex items-center px-4 py-2 gap-x-2">
                    <x-checkbox type="radio" id="status-filter-none" name="status_filter" value="" />
                    All
                </x-input-label>
            </li>
            <li class="hover:bg-gray-100">
                <x-input-label for="status-filter-{{App\Enums\StatusEnum::Declined}}" class="flex items-center px-4 py-2 gap-x-2">
                    <x-checkbox type="radio" id="status-filter-{{App\Enums\StatusEnum::Declined}}" name="status_filter" value="{{App\Enums\StatusEnum::Declined}}" />
                    {{ucfirst(App\Enums\StatusEnum::Declined->value)}}
                </x-input-label>
            </li>
            <li class="hover:bg-gray-100">
                <x-input-label for="status-filter-{{App\Enums\StatusEnum::Completed}}" class="flex items-center px-4 py-2 gap-x-2">
                    <x-checkbox type="radio" id="status-filter-{{App\Enums\StatusEnum::Completed}}" name="status_filter" value="{{App\Enums\StatusEnum::Completed}}" />
                    {{ucfirst(App\Enums\StatusEnum::Completed->value)}}
                </x-input-label>
            </li>
        </ul>
        
        <div class="p-2 mt-2 flex gap-x-2 justify-end">
            <x-secondary-button id="reset-filter-button" x-data x-on:click="filterOpen = false">Reset</x-secondary-button>
            <x-primary-button type="submit" x-data x-on:click="filterOpen = false">Filter</x-primary-button>
        </div>
    </x-slot>
</x-filter>

<script type="module">
    $('#reset-filter-button').click(function(e) {
        let form = $("#history-search-form");
        form.get(0).reset();
        form.submit();
    });
</script>