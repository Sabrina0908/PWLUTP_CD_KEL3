<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

class AuthController extends Controller
{
    // Menampilkan halaman Register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Menangani proses Register
    public function register(Request $request)
    {
        try {
            // 1. Validasi Input
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            // 2. Buat User baru
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'user',
            ]);

            // 3. Langsung login setelah register
            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat pendaftaran. Silakan coba lagi.')->withInput();
        }
    }

    // Menampilkan halaman Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menangani proses Login
    public function login(Request $request)
    {
        try {
            // 1. Validasi Input
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            // 2. Coba autentikasi
            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard')->with('success', 'Login berhasil!');
            }

            // Login gagal
            throw ValidationException::withMessages([
                'email' => ['Kredensial yang diberikan tidak cocok dengan catatan kami.'],
            ]);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat login. Silakan coba lagi.')->withInput();
        }
    }

    // Menangani proses Logout
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success', 'Logout berhasil!');
        } catch (Exception $e) {
            return redirect('/')->with('error', 'Terjadi kesalahan saat logout.');
        }
    }
}
