<x-dropdown align="right" width="64" :dismissOnClick="false">
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
        <ul class="space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioButton">
            <li class="hover:bg-gray-100">
                <div class="px-4 py-2">
                    <x-input-label for="status-filter-none" class="flex items-center gap-x-2">
                        <x-checkbox type="radio" id="status-filter-none" name="status_filter" value="" />
                        All
                    </x-input-label>
                </div>
            </li>
            <li class="hover:bg-gray-100">
                <div class="px-4 py-2">
                    <x-input-label for="status-filter-{{App\Enums\StatusEnum::Pending}}" class="flex items-center gap-x-2">
                        <x-checkbox type="radio" id="status-filter-{{App\Enums\StatusEnum::Pending}}" name="status_filter" value="{{App\Enums\StatusEnum::Pending}}" />
                        {{ucfirst(App\Enums\StatusEnum::Pending->value)}}
                    </x-input-label>
                </div>
            </li>
            <li class="hover:bg-gray-100">
                <div class="px-4 py-2">
                    <x-input-label for="status-filter-{{App\Enums\StatusEnum::Approved}}" class="flex items-center gap-x-2">
                        <x-checkbox type="radio" id="status-filter-{{App\Enums\StatusEnum::Approved}}" name="status_filter" value="{{App\Enums\StatusEnum::Approved}}" />
                        {{ucfirst(App\Enums\StatusEnum::Approved->value)}}
                    </x-input-label>
                </div>
            </li>
            <li class="hover:bg-gray-100">
                <div class="px-4 py-2">
                    <x-input-label for="status-filter-{{App\Enums\StatusEnum::Ready}}" class="flex items-center gap-x-2">
                        <x-checkbox type="radio" id="status-filter-{{App\Enums\StatusEnum::Ready}}" name="status_filter" value="{{App\Enums\StatusEnum::Ready}}" />
                        {{ucfirst(App\Enums\StatusEnum::Ready->value)}}
                    </x-input-label>
                </div>
            </li>
        </ul>

        <div class="p-2 mt-2 flex gap-x-2 justify-end">
            <x-secondary-button id="reset-filter-button">Reset</x-secondary-button>
            <x-primary-button type="submit">Filter</x-primary-button>
        </div>
    </x-slot>
</x-dropdown>

<script type="module">
    $('#reset-filter-button').click(function(e) {
        let form = $("#my-request-search-form");
        form.get(0).reset();
        form.submit();
    });
</script>