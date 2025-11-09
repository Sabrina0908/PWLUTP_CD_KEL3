<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
        // 1. Validasi Input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // 2. Buat User baru (role default 'user' sudah diset di migrasi)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // Password dienkripsi otomatis oleh $casts di Model User
            'password' => Hash::make($request->password), 
            'role' => 'user', // Set default role
        ]);

        // 3. Langsung login setelah register
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    // Menampilkan halaman Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menangani proses Login
    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba autentikasi
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // 3. Redirect ke dashboard (logika redirect per role ada di DashboardController)
            return redirect()->intended('/dashboard');
        }

        // Jika gagal, kembalikan dengan error
        throw ValidationException::withMessages([
            'email' => ['Kredensial yang diberikan tidak cocok dengan catatan kami.'],
        ]);
    }

    // Menangani proses Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
