<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi form login
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // penting untuk session keamanan
            return redirect()->intended(route('log.index'));
        }

        // Jika gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showRegister()
    {
        $users = User::all();
        return view('auth.register', compact('users'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'jabatan' => 'required|in:kepala_dinas,kepala_bidang,staff',
            'atasan_id' => 'nullable|exists:users,id',
        ]);

        // Validasi relasi jabatan-atasan
        if ($request->jabatan === 'staff') {
            $atasan = User::find($request->atasan_id);
            if (!$atasan || $atasan->jabatan !== 'kepala_bidang') {
                return back()->withErrors(['atasan_id' => 'Staff hanya boleh memilih Kepala Bidang sebagai atasan.']);
            }
        } elseif ($request->jabatan === 'kepala_bidang') {
            $atasan = User::find($request->atasan_id);
            if (!$atasan || $atasan->jabatan !== 'kepala_dinas') {
                return back()->withErrors(['atasan_id' => 'Kepala Bidang hanya boleh memilih Kepala Dinas sebagai atasan.']);
            }
        } elseif ($request->jabatan === 'kepala_dinas') {
            $request['atasan_id'] = null;
        }

        // Simpan user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jabatan' => $request->jabatan,
            'atasan_id' => $request->atasan_id,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil');
    }

}
