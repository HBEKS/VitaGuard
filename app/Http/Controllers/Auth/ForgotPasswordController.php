<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function resetDirect(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.exists' => 'Email ini tidak terdaftar di sistem kami.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // 2. Cari User Berdasarkan Email
        $user = User::where('email', $request->email)->first();

        // 3. Update Password
        $user->password = Hash::make($request->password);
        $user->save();

        // 4. Redirect ke Halaman Login dengan Pesan Sukses
        return redirect()->route('login')->with('status', 'Password berhasil diperbarui! Silakan login dengan password baru.');
    }
}
