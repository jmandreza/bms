<!-- Last Name -->
<div>
    <x-input-label for="lname-field" :value="__('Last Name')" />
    <x-text-input id="lname-field" class="block mt-1 w-full" type="text" name="lname" :value="old('lname')" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('lname')" class="mt-2" />
</div>

<!-- First Name -->
<div>
    <x-input-label for="fname-field" :value="__('First Name')" />
    <x-text-input id="fname-field" class="block mt-1 w-full" type="text" name="fname" :value="old('fname')" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('fname')" class="mt-2" />
</div>

<!-- Middle Name -->
<div>
    <x-input-label for="mname-field" :value="__('Middle Name')" />
    <x-text-input id="mname-field" class="block mt-1 w-full" type="text" name="mname" :value="old('mname')" autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('mname')" class="mt-2" />
</div>

<!-- Birthdate-->
<div>
    <x-input-label for="birthdate-field" :value="__('Birthdate')" />
    <x-text-input type="date" id="birthdate-field" class="block mt-1 w-full" name="birthdate" :value="old('birthdate')" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
</div>

<!-- Gender -->
<div>
    <x-input-label :associate="false" value="Gender" />
    <div class="flex gap-x-4">
        <x-input-label for="gender-field-male" class="space-x-2">
            <x-checkbox type="radio" name="gender" id="gender-field-male" value="male" :checked="old('gender') === 'male'" />
            Male
        </x-input-label>
        <x-input-label for="gender-field-female" class="space-x-2">
            <x-checkbox type="radio" name="gender" id="gender-field-female" value="female" :checked="old('gender') === 'female'" />
            Female
        </x-input-label>
        <x-input-label for="gender-field-others" class="space-x-2">
            <x-checkbox type="radio" name="gender" id="gender-field-others" value="others" :checked="old('gender') === 'others'" />
            Others
        </x-input-label>
    </div>
    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
</div>

<!-- Phone Number -->
<div>
    <x-input-label for="phone-field" :value="__('Phone Number')" />
    <x-text-input id="phone-field" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
</div>