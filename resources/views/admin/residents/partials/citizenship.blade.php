<!-- Household No. -->
<div>
    <x-input-label for="household-no-field" :value="__('Household No.')" />
    <x-text-input id="household-no-field" class="block mt-1 w-full" type="number" name="household_no" :value="old('household_no')" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('household_no')" data-error="household_no" class="mt-2" />
</div>

<!-- Zone -->
<div>
    <x-input-label for="zone-field" :value="__('Zone')" />
    <x-text-input id="zone-field" class="block mt-1 w-full" type="number" name="zone" :value="old('zone')" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('zone')" data-error="zone" class="mt-2" />
</div>

<!-- Civil Status -->
<div>
    <x-input-label for="civil-status-field" :value="__('Civil Status')" />
    <x-select name="civil_status" id="civil-status-field" required>
        <option value="" selected disabled>Select One</option>
        <option value="single" @if(old('civil_status') === 'single') selected @endif>Single</option>
        <option value="married" @if(old('civil_status') === 'married') selected @endif>Married</option>
        <option value="widowed" @if(old('civil_status') === 'widowed') selected  @endif>Widowed</option>
        <option value="separated" @if(old('civil_status') === 'separated') selected @endif>Separated</option>
    </x-select>
    <x-input-error :messages="$errors->get('civil_status')" data-error="civil_status" class="mt-2" />
</div>

<!-- Occupation -->
<div>
    <x-input-label for="occupation-field" :value="__('Occupation')" />
    <x-text-input id="occupation-field" class="block mt-1 w-full" type="text" name="occupation" :value="old('occupation')" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('occupation')" data-error="occupation" class="mt-2" />
</div>

<!-- Nationality -->
<div>
    <x-input-label for="lname-field" :value="__('Nationality')" />
    <x-text-input id="nationality-field" class="block mt-1 w-full" type="text" name="nationality" :value="old('nationality')" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('nationality')" data-error="nationality" class="mt-2" />
</div>

<!-- 4P's Member -->
<div class="sm:col-start-1">
    <x-input-label :associate="false" :value="__('4P\'s Member')" />
    <div class="flex gap-x-4">
        <x-input-label for="four-ps-field-yes" class="space-x-2">
            <x-checkbox type="radio" id="four-ps-field-yes" name="fourps_member" value="1" :checked="old('fourps_member') === 1" />
            Yes
        </x-input-label>
        <x-input-label for="four-ps-field-no" class="space-x-2">
            <x-checkbox type="radio" id="four-ps-field-no" name="fourps_member" value="0" :checked="old('fourps_member') === 0" />
            No
        </x-input-label>
    </div>
    <x-input-error :messages="$errors->get('fourps_member')" data-error="fourps_member" class="mt-2" />
</div>

 <!-- Fully Vaccinated -->
 <div>
    <x-input-label :associate="false" :value="__('Fully Vaccinated')" />
    <div class="flex gap-x-4">
        <x-input-label for="fully-vaxxed-field-yes" class="space-x-2">
            <x-checkbox type="radio" id="fully-vaxxed-field-yes" name="fully_vaxxed" value="1" :checked="old('fully_vaxxed') === 1" />
            Yes
        </x-input-label>
        <x-input-label for="fully-vaxxed-field-no" class="space-x-2">
            <x-checkbox type="radio" id="fully-vaxxed-field-no" name="fully_vaxxed" value="0" :checked="old('fully_vaxxed') === 0" />
            No
        </x-input-label>
    </div>
    <x-input-error :messages="$errors->get('fully_vaxxed')" data-error="fully_vaxxed" class="mt-2" />
</div>

 <!-- Registered Voter -->
 <div>
    <x-input-label :associate="false" :value="__('Registered Voter')" />
    <div class="flex gap-x-4">
        <x-input-label for="registered-voter-field-yes" class="space-x-2">
            <x-checkbox type="radio" id="registered-voter-field-yes" name="voter" value="1" :checked="old('voter') === 1" />
            Yes
        </x-input-label>
        <x-input-label for="registered-voter-field-no" class="space-x-2">
            <x-checkbox type="radio" id="registered-voter-field-no" name="voter" value="0" :checked="old('voter') === 0" />
            No
        </x-input-label>
    </div>
    <x-input-error :messages="$errors->get('voter')" data-error="voter" class="mt-2" />
</div>