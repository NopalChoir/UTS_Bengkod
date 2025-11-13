<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
        {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                if ($user->role == 'admin') {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->role == 'dokter') {
                    return redirect()->route('dokter.dashboard');
                } else {
                    return redirect()->route('pasien.dashboard');
                }
            }
            return back()->withErrors(['email' => 'Email atau Password Salah !']);
        }

        public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:225'],
            'alamat' => ['required', 'string', 'max:225'],
            'no_ktp' => ['required', 'string', 'max:30'],
            'no_hp' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:225', 'unique:users,email'],
            'password' => ['required', 'confirmed'],
        ]);

        if(User::where('no_ktp', $request->no_ktp)->exists()) {
            return back()->withErrors(['no_ktp' => 'Nomor KTP sudah terdaftar']);
        }

        $no_rm = date('Ym') .'-' . str_pad(
            User::where('no_rm', 'like', date('Ym') . '-%')->count() + 1,
            3,
            '0',
            STR_PAD_LEFT
        );

        User::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            // Wajib: Hash password sebelum disimpan
            'password' => Hash::make($request->password),
            // Wajib: Tetapkan role default untuk pengguna yang mendaftar
            'role' => 'pasien',
        ]);

        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function dokter(){
        $data = Poli::with('dokters')->get();
        return $data;
    }
}
