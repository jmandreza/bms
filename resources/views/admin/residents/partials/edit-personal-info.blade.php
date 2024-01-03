<!-- Last Name -->
<div>
    <x-input-label for="new-lname-field" :value="__('Last Name')" />
    <x-text-input id="new-lname-field" class="block mt-1 w-full" type="text" name="lname" :value="old('lname', $user->resident->lname)" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('lname')" data-error="lname" class="mt-2" />
</div>

<!-- First Name -->
<div>
    <x-input-label for="new-fname-field" :value="__('First Name')" />
    <x-text-input id="new-fname-field" class="block mt-1 w-full" type="text" name="fname" :value="old('fname', $user->resident->fname)" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('fname')" data-error="fname" class="mt-2" />
</div>

<!-- Middle Name -->
<div>
    <x-input-label for="new-mname-field" :value="__('Middle Name')" />
    <x-text-input id="new-mname-field" class="block mt-1 w-full" type="text" name="mname" :value="old('mname', $user->resident->mname)" autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('mname')" data-error="mname" class="mt-2" />
</div>

<!-- Birthdate-->
<div>
    <x-input-label for="new-birthdate-field" :value="__('Birthdate')" />
    <x-text-input type="date" id="new-birthdate-field" class="block mt-1 w-full" name="birthdate" :value="old('birthdate', $user->resident->birthdate)" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('birthdate')" data-error="birthdate" class="mt-2" />
</div>

<!-- Gender -->
<div class="sm:col-span-2">
    <x-input-label :associate="false" value="Gender" />
    <div class="flex gap-x-4">
        <x-input-label for="new-gender-field-male" class="space-x-2">
            <x-checkbox type="radio" name="gender" id="new-gender-field-male" value="male" :checked="old('gender', $user->resident->gender) === 'male'" />
            Male
        </x-input-label>
        <x-input-label for="new-gender-field-female" class="space-x-2">
            <x-checkbox type="radio" name="gender" id="new-gender-field-female" value="female" :checked="old('gender', $user->resident->gender) === 'female'" />
            Female
        </x-input-label>
        <x-input-label for="new-gender-field-others" class="space-x-2">
            <x-checkbox type="radio" name="gender" id="new-gender-field-others" value="others" :checked="old('gender', $user->resident->gender) === 'others'" />
            Others
        </x-input-label>
    </div>
    <x-input-error :messages="$errors->get('gender')" data-error="gender" class="mt-2" />
</div>

<!-- Phone Number -->
<div>
    <x-input-label for="new-phone-field" :value="__('Phone Number')" />
    <x-text-input id="new-phone-field" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $user->resident->phone)" data-mask="00000000000" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('phone')" data-error="phone" class="mt-2" />
</div>

<!-- Email Address -->
<div>
    <x-input-label for="new-email-field" :value="__('Email')" />
    <x-text-input id="new-email-field" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required autocomplete="username" />
    <x-input-error :messages="$errors->get('email')" data-error="email" class="mt-2" />
</div>