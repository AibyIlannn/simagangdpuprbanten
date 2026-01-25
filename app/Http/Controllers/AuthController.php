<?php

namespace App\Http\Controllers;

use App\Models\SuperAdmin;
use App\Models\Admin;
use App\Models\Kordinator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('masuk');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // Cek SuperAdmin
        if ($superAdmin = SuperAdmin::where('email', $credentials['email'])->first()) {
            if (Hash::check($credentials['password'], $superAdmin->password)) {
                Auth::guard('superadmin')->login($superAdmin, $remember);
                $superAdmin->update(['terakhir_login' => now()]);
                return redirect()->intended('/dashboard');
            }
        }

        // Cek Admin
        if ($admin = Admin::where('email', $credentials['email'])->first()) {
            if (Hash::check($credentials['password'], $admin->password)) {
                Auth::guard('admin')->login($admin, $remember);
                $admin->update(['terakhir_login' => now()]);
                return redirect()->intended('/dashboard');
            }
        }

        // Cek Kordinator Sekolah
        if ($kordinator = Kordinator::where('email', $credentials['email'])->first()) {
            if (Hash::check($credentials['password'], $kordinator->password)) {
                Auth::guard('kordinator')->login($kordinator, $remember);
                return redirect()->intended('/verification');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password anda salah.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        if (Auth::guard('superadmin')->check()) {
            Auth::guard('superadmin')->logout();
        } elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('kordinator')->check()) {
            Auth::guard('kordinator')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function redirectBasedOnRole($user)
    {
        if ($user instanceof SuperAdmin || $user instanceof Admin) {
            return redirect('/dashboard');
        }
        
        if ($user instanceof Kordinator) {
            return redirect('/verification');
        }

        return redirect('/');
    }
}