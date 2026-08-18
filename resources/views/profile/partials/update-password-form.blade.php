<span class="card-kicker">{{ __('Security') }}</span>
<div class="card-title mb-1">{{ __('Update password') }}</div>
<p class="card-body mb-4">{{ __('Use a long, random password to keep your account secure.') }}</p>

<form method="post" action="{{ route('password.update') }}" class="flex flex-col gap-3.5">
    @csrf
    @method('put')

    <div class="field">
        <label for="update_password_current_password">{{ __('Current password') }}</label>
        <input class="input" id="update_password_current_password" name="current_password" type="password" autocomplete="current-password">
        @error('current_password', 'updatePassword')
            <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="update_password_password">{{ __('New password') }}</label>
        <input class="input" id="update_password_password" name="password" type="password" autocomplete="new-password">
        @error('password', 'updatePassword')
            <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="update_password_password_confirmation">{{ __('Confirm password') }}</label>
        <input class="input" id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
        @error('password_confirmation', 'updatePassword')
            <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        @if (session('status') === 'password-updated')
            <span class="text-sm" style="color:var(--color-accent)">{{ __('Saved.') }}</span>
        @endif
    </div>
</form>
