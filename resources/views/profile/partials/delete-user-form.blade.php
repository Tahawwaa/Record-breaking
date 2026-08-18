<span class="card-kicker">{{ __('Danger zone') }}</span>
<div class="card-title mb-1">{{ __('Delete account') }}</div>
<p class="card-body mb-4">{{ __('Once your account is deleted, all of its data is permanently gone. Please be certain.') }}</p>

<button type="button" class="btn" style="background:#3a1c1c;color:#ff8080" onclick="openDeleteAccountModal()">{{ __('Delete account') }}</button>

<div id="delete-account-modal" class="{{ $errors->userDeletion->isNotEmpty() ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.6)" onclick="if (event.target === this) closeDeleteAccountModal()">
    <div class="card elev-sm w-full" style="max-width:380px">
        <div class="card-title mb-1">{{ __('Are you sure you want to delete your account?') }}</div>
        <p class="card-body mb-4">{{ __('Enter your password to confirm. This cannot be undone.') }}</p>
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')
            <div class="field">
                <label for="delete_password" class="sr-only">{{ __('Password') }}</label>
                <input class="input" id="delete_password" name="password" type="password" placeholder="{{ __('Password') }}" autofocus>
                @error('password', 'userDeletion')
                    <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex gap-2 justify-end mt-5">
                <button type="button" class="btn" style="background:transparent;border:1px solid var(--color-divider);color:var(--color-text)" onclick="closeDeleteAccountModal()">{{ __('Cancel') }}</button>
                <button type="submit" class="btn" style="background:#5a1f1f;color:#ff8080">{{ __('Delete account') }}</button>
            </div>
        </form>
    </div>
</div>
