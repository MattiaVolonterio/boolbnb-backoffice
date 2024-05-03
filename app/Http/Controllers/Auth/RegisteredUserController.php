<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;

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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'surname' => ['nullable', 'string', 'max:50'],
            'birthday' => ['nullable', 'date', 'before:' . Carbon::now()->subYears(18)->format('Y-m-d')],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'Il nome è obbligatorio',
            'name.max' => "Il nome dev'essere di 50 caratteri",
            'surname.max' => "Il cognome dev'essere di 50 caratteri",
            'birthday.before' => "La data inserita dev'essere precedente al " . Carbon::now()->subYears(18)->format('Y-m-d'),
            'email.required' => "L'e-mail è obbligatoria",
            'email.email' => "Inserire un'e-mail valida",
            'email.max' => "l'e-mail non può essere più lunga di 255 caratteri",
            'email.unique' => "l'e-mail inserita è già presente",
            'password.min' => "La password dev'essere minimo di 8 caratteri",
            'password.confirmed' => "La password inserita non corrisponde",
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'birthday' => $request->birthday,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
