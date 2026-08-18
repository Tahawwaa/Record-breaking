<span class="card-kicker">{{ __('Account') }}</span>
<div class="card-title mb-1">{{ __('Profile information') }}</div>
<p class="card-body mb-4">{{ __("Update your account's name and email address.") }}</p>

<form method="post" action="{{ route('profile.update') }}" class="flex flex-col gap-3.5">
    @csrf
    @method('patch')

    <div class="field">
        <label for="name">{{ __('Name') }}</label>
        <input class="input" id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')
            <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="email">{{ __('Email') }}</label>
        <input class="input" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
            <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        @if (session('status') === 'profile-updated')
            <span class="text-sm" style="color:var(--color-accent)">{{ __('Saved.') }}</span>
        @endif
    </div>
</form>
