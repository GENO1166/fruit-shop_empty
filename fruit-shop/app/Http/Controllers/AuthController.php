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
        // dd($user, $loginType, $request->login);
        // die;
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

    public function register(Request $request)
    {
        $request->validate([
            'titles'     => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'username'   => 'required|string|unique:users|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|string|max:10',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        $emailExists = DB::table('users')
            ->where('email', $request->email)
            ->exists();

        if ($emailExists == true) {
            return redirect()->back()
                ->with('error', 'อีเมลนี้มีผู้ใช้งานในระบบแล้ว');
        }

        DB::table('users')->insert([
            'titles'     => $request->titles,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'username'   => $request->username,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'role'       => 'user',
            'status'     => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('login')->with('success', 'สมัครสมาชิกสำเร็จ');
    }
}
