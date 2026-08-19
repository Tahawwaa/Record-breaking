<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Database\Seeders\DefaultExercisesSeeder;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Accept Persian/Arabic-Indic digits (a Persian keyboard's default) as well as ASCII ones.
        $request->merge([
            'phone' => $this->toAsciiDigits((string) $request->input('phone')),
        ]);

        $request->validate([
            'phone' => ['required', 'string', 'regex:/^\+?[0-9]{7,15}$/', 'unique:'.User::class],
            'username' => ['required', 'string', 'min:3', 'max:255', 'alpha_dash', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [], [
            'phone' => __('Phone number'),
            'username' => __('Username'),
        ]);

        $user = User::create([
            'name' => $request->username,
            'username' => $request->username,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        (new DefaultExercisesSeeder())->run($user);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Converts Persian and Arabic-Indic digits to ASCII, so a phone number typed
     * on a Persian keyboard (e.g. "۰۹۱۲...") still passes/stores as plain digits.
     */
    private function toAsciiDigits(string $value): string
    {
        return strtr($value, [
            '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
            '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
            '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
            '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
        ]);
    }
}
