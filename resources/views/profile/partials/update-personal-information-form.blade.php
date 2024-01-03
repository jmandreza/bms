<header>
    <h2 class="text-lg font-medium text-gray-900">
        {{ __('Personal Information') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600">
        {{ __("Update your personal information to reflect you better.") }}
    </p>
</header>
<form action="{{route('profile.update-personal', $user)}}" method="post" class="mt-6 space-y-4">
    @method('put')
    @csrf

    <!-- Last Name -->
    <div>
        <x-input-label for="lname-field" :value="__('Last Name')" />
        <x-text-input id="lname-field" class="block mt-1 w-full" type="text" name="lname" :value="old('lname', $user->resident->lname)" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('lname')" class="mt-2" />
    </div>

    <!-- First Name -->
    <div>
        <x-input-label for="fname-field" :value="__('First Name')" />
        <x-text-input id="fname-field" class="block mt-1 w-full" type="text" name="fname" :value="old('fname', $user->resident->fname)" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('fname')" class="mt-2" />
    </div>

    <!-- Middle Name -->
    <div>
        <x-input-label for="mname-field" :value="__('Middle Name')" />
        <x-text-input id="mname-field" class="block mt-1 w-full" type="text" name="mname" :value="old('mname', $user->resident->mname)" autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('mname')" class="mt-2" />
    </div>

    <!-- Birthdate-->
    <div>
        <x-input-label for="birthdate-field" :value="__('Birthdate')" />
        <x-text-input type="date" id="birthdate-field" class="block mt-1 w-full" name="birthdate" :value="old('birthdate', $user->resident->birthdate)" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
    </div>

    <!-- Gender -->
    <div>
        <x-input-label :associate="false" value="Gender" />
        <div class="flex gap-x-4">
            <x-input-label for="gender-field-male" class="space-x-2">
                <x-checkbox type="radio" name="gender" id="gender-field-male" value="male" :checked="old('gender', $user->resident->gender) === 'male'" />
                Male
            </x-input-label>
            <x-input-label for="gender-field-female" class="space-x-2">
                <x-checkbox type="radio" name="gender" id="gender-field-female" value="female" :checked="old('gender', $user->resident->gender) === 'female'" />
                Female
            </x-input-label>
            <x-input-label for="gender-field-others" class="space-x-2">
                <x-checkbox type="radio" name="gender" id="gender-field-others" value="others" :checked="old('gender', $user->resident->gender) === 'others'" />
                Others
            </x-input-label>
        </div>
        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
    </div>

    <!-- Phone Number -->
    <div>
        <x-input-label for="phone-field" :value="__('Phone Number')" />
        <x-text-input id="phone-field" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $user->resident->phone)" data-mask="00000000000" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>

    <div class="flex gap-x-4">
        <!-- Household No. -->
        <div>
            <x-input-label for="household-no-field" :value="__('Household No.')" />
            <x-text-input id="household-no-field" class="block mt-1 w-full" type="number" name="household_no" :value="old('household_no', $user->resident->household_no)" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('household_no')" class="mt-2" />
        </div>

        <!-- Zone -->
        <div>
            <x-input-label for="zone-field" :value="__('Zone')" />
            <x-text-input id="zone-field" class="block mt-1 w-full" type="number" name="zone" :value="old('zone', $user->resident->zone)" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('zone')" class="mt-2" />
        </div>
    </div>

    <!-- Civil Status -->
    <div>
        <x-input-label for="civil-status-field" :value="__('Civil Status')" />
        <x-select name="civil_status" id="civil-status-field" class="mt-1" required>
            <option value="" selected disabled>Select One</option>
            <option value="single" @if(old('civil_status', $user->resident->civil_status) === 'single') selected @endif>Single</option>
            <option value="married" @if(old('civil_status', $user->resident->civil_status) === 'married') selected @endif>Married</option>
            <option value="widowed" @if(old('civil_status', $user->resident->civil_status) === 'widowed') selected  @endif>Widowed</option>
            <option value="separated" @if(old('civil_status', $user->resident->civil_status) === 'separated') selected @endif>Separated</option>
        </x-select>
        <x-input-error :messages="$errors->get('civil_status')" class="mt-2" />
    </div>

    <!-- Occupation -->
    <div>
        <x-input-label for="occupation-field" :value="__('Occupation')" />
        <x-text-input id="occupation-field" class="block mt-1 w-full" type="text" name="occupation" :value="old('occupation', $user->resident->occupation)" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
    </div>

    <!-- Nationality -->
    <div>
        <x-input-label for="lname-field" :value="__('Nationality')" />
        <x-text-input id="nationality-field" class="block mt-1 w-full" type="text" name="nationality" :value="old('nationality', $user->resident->nationality)" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('nationality')" class="mt-2" />
    </div>

    <!-- 4P's Member -->
    <div>
        <x-input-label :associate="false" :value="__('4P\'s Member')" />
        <div class="flex gap-x-4">
            <x-input-label for="four-ps-field-yes" class="space-x-2">
                <x-checkbox type="radio" id="four-ps-field-yes" name="fourps_member" value="1" :checked="old('fourps_member', $user->resident->fourps_member) === 1" />
                Yes
            </x-input-label>
            <x-input-label for="four-ps-field-no" class="space-x-2">
                <x-checkbox type="radio" id="four-ps-field-no" name="fourps_member" value="0" :checked="old('fourps_member', $user->resident->fourps_member) === 0" />
                No
            </x-input-label>
        </div>
        <x-input-error :messages="$errors->get('fourps_member')" class="mt-2" />
    </div>

    <!-- Fully Vaccinated -->
    <div>
        <x-input-label :associate="false" :value="__('Fully Vaccinated')" />
        <div class="flex gap-x-4">
            <x-input-label for="fully-vaxxed-field-yes" class="space-x-2">
                <x-checkbox type="radio" id="fully-vaxxed-field-yes" name="fully_vaxxed" value="1" :checked="old('fully_vaxxed', $user->resident->fully_vaxxed) === 1" />
                Yes
            </x-input-label>
            <x-input-label for="fully-vaxxed-field-no" class="space-x-2">
                <x-checkbox type="radio" id="fully-vaxxed-field-no" name="fully_vaxxed" value="0" :checked="old('fully_vaxxed', $user->resident->fully_vaxxed) === 0" />
                No
            </x-input-label>
        </div>
        <x-input-error :messages="$errors->get('fully_vaxxed')" class="mt-2" />
    </div>

    <!-- Registered Voter -->
    <div>
        <x-input-label :associate="false" :value="__('Registered Voter')" />
        <div class="flex gap-x-4">
            <x-input-label for="registered-voter-field-yes" class="space-x-2">
                <x-checkbox type="radio" id="registered-voter-field-yes" name="voter" value="1" :checked="old('voter', $user->resident->voter) === 1" />
                Yes
            </x-input-label>
            <x-input-label for="registered-voter-field-no" class="space-x-2">
                <x-checkbox type="radio" id="registered-voter-field-no" name="voter" value="0" :checked="old('voter', $user->resident->voter) === 0" />
                No
            </x-input-label>
        </div>
        <x-input-error :messages="$errors->get('voter')" class="mt-2" />
    </div>

    <x-primary-button type="submit">Save</x-primary-button>
</form>