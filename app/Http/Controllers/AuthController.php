<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(Request $request)
    {

        return view('loginpage');
    }

    public function login(Request $request)
    {
        
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);
        
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = DB::table('users')->where($loginType, $request->login)
            ->select(
                'id',
                'role'
            )
            ->first();

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if ($user && Auth::validate($credentials)) {
            Auth::loginUsingId($user->id);

            $request->session()->regenerate();
            
            return redirect()->route('homepage')->with('success', 'ยินดีต้อนรับเข้าสู่ระบบ');
        }

        return back()->with('error', 'ชื่อผู้ใช้/อีเมล หรือรหัสผ่านไม่ถูกต้อง');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function register_page()
    {
        return view('register');
    }
}
