<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | REGISTER PAGE
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('auth.register');
    }


    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);


        $user = User::create([
            'name' => $validated['name'],

            'email' => strtolower(
                $validated['email']
            ),

            'password' => Hash::make(
                $validated['password']
            ),

            // Registrasi publik selalu customer.
            'role' => 'customer',
        ]);


        Auth::login($user);


        /*
         * Regenerate session ID untuk
         * mencegah session fixation.
         */
        $request->session()->regenerate();


        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Registrasi berhasil.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN PAGE
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);


        /*
         * Normalisasi email.
         */
        $email = strtolower(
            trim($credentials['email'])
        );


        /*
         * Key rate limiter dibuat dari
         * email + IP address.
         */
        $throttleKey =
            Str::lower($email) .
            '|' .
            $request->ip();


        /*
         * Maksimal 5 kegagalan login.
         */
        if (
            RateLimiter::tooManyAttempts(
                $throttleKey,
                5
            )
        ) {
            $seconds =
                RateLimiter::availableIn(
                    $throttleKey
                );


            throw ValidationException::withMessages([
                'email' =>
                    'Terlalu banyak percobaan login. ' .
                    'Silakan coba lagi dalam ' .
                    $seconds .
                    ' detik.',
            ]);
        }


        /*
         * Coba login.
         */
        if (
            Auth::attempt([
                'email' => $email,
                'password' =>
                    $credentials['password'],
            ])
        ) {

            /*
             * Login berhasil:
             * hapus hitungan percobaan gagal.
             */
            RateLimiter::clear(
                $throttleKey
            );


            /*
             * Buat session ID baru.
             */
            $request
                ->session()
                ->regenerate();


            /*
             * Admin diarahkan ke dashboard.
             */
            if (
                Auth::user()->role === 'admin'
            ) {
                return redirect()
                    ->route(
                        'admin.dashboard'
                    );
            }


            /*
             * Customer diarahkan ke Collection.
             */
            return redirect()
                ->route(
                    'products.index'
                );
        }


        /*
         * Login gagal:
         * tambah hitungan rate limiter.
         *
         * decaySeconds = 60
         */
        RateLimiter::hit(
            $throttleKey,
            60
        );


        return back()
            ->withErrors([
                'email' =>
                    'Email atau password salah.',
            ])
            ->onlyInput('email');
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();


        /*
         * Hapus session lama.
         */
        $request
            ->session()
            ->invalidate();


        /*
         * Buat CSRF token baru.
         */
        $request
            ->session()
            ->regenerateToken();


        return redirect()
            ->route('login')
            ->with(
                'success',
                'Berhasil logout.'
            );
    }
}