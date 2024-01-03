<!-- Username -->
<div>
    <x-input-label for="username-field" :value="__('Username')" />
    <x-text-input id="username-field" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('username')" data-error="username" class="mt-2" />
</div>

<!-- Email Address -->
<div>
    <x-input-label for="email-field" :value="__('Email')" />
    <x-text-input id="email-field" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
    <x-input-error :messages="$errors->get('email')" data-error="email" class="mt-2" />
</div>

<!-- Password -->
<div>
    <x-input-label for="password-field" :value="__('Password')" />

    <x-text-input id="password-field" class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required autocomplete="new-password" />

    <x-input-error :messages="$errors->get('password')" data-error="password" class="mt-2" />
</div>

<!-- Confirm Password -->
<div>
    <x-input-label for="password_confirmation_field" :value="__('Confirm Password')" />

    <x-text-input id="password_confirmation_field" class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation" required autocomplete="new-password" />

    <x-input-error :messages="$errors->get('password_confirmation')" data-error="password_confirmation" class="mt-2" />
</div>