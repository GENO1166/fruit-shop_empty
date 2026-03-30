<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $userid = Auth::id();
        $userdata = DB::table('users') 
            ->where('id', $userid)
            ->select(
                'first_name',
                'last_name',
                'phone',
                'titles',
                'email',
                'created_at',
                'updated_at'
            )
            ->first();
        // dd($userdata);
        
        return view('profile', compact('userdata'));
    }

    public function edit_profile(Request $request, $userid)
    {
        if ($userid != Auth::id()) {
            return redirect()->back()->with('error', 'ขออภัย คุณไม่มีสิทธิ์แก้ไขข้อมูลส่วนตัวของสมาชิกท่านอื่น');
        }

        $request->validate([
            'titles'     => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|digits:10',
        ]);

        $emailExists = DB::table('users')
            ->where('email', $request->email)
            ->where('id', '!=', $userid)
            ->exists();

        if ($emailExists == true) {
            return redirect()->back()
                ->with('error', 'อีเมลนี้มีผู้ใช้งานในระบบแล้ว');
        }

        $updatedata = [
            'titles' => $request->titles,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' =>  $request->email,
            'phone' => $request->phone,
            'updated_at' => now(),
        ];

        DB::table('users')->where('id', $userid)->update($updatedata);
                
        return redirect()->back()->with('success', 'แก้ไขข้อมูลส่วนตัวเรียบร้อยแล้ว');
    }

    public function change_password(Request $request, $userid)
    {
        if ($userid != Auth::id()) {
            return redirect()->back()->with('error', 'ขออภัย คุณไม่มีสิทธิ์แก้ไขข้อมูลส่วนตัวของสมาชิกท่านอื่น');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required',
            'new_password_confirmation' => 'required',
        ]);

        $user = DB::table('users')->where('id', $userid)->first();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'รหัสผ่านปัจจุบันไม่ถูกต้อง');
        }

        if (Hash::check($request->new_password, $user->password)) {
            return back()->with('error', 'ห้ามใช้รหัสผ่านเดิม');
        }

        if ($request->new_password !== $request->new_password_confirmation)
        {
            return redirect()->back()->with('error', 'ยืนยันรหัสผ่านไม่ตรงกัน');
        }

        DB::table('users')->where('id', $userid)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()->with('success', 'เปลี่ยนรหัสผ่านสำเร็จ');
    }

    public function index_manage()
    {
        $userid = Auth::id();
        $user_role = DB::table('users')->where('id', $userid)->select('role')->first();

        if($user_role == 'user')
        {
            return redirect()->back();
        }

        $userdata = DB::table('users')->get();

        return view('user.user_manage', compact('userdata', 'user_role'));
    }

    public function user_manage($user_id)
    {
        $user = DB::table('users')->where('id', $user_id)->first();
        $admin = DB::table('users')
            ->where('id', Auth::id())
            ->whereIn('role', ['superadmin', 'admin'])
            ->first();

        return view('user.user_edit', compact('user', 'admin'));
    }

    public function user_update(Request $request, $id)
    {
        $currentAdmin = DB::table('users')->where('id', Auth::id())->first();
        $targetUser = DB::table('users')->where('id', $id)->first();

        if (!$targetUser) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลผู้ใช้งาน');
        }

        if ($currentAdmin->role !== 'superadmin') {
            if ($targetUser->role === 'superadmin' || $targetUser->role === 'admin') {
                return redirect()->back()->with('error', 'คุณไม่มีสิทธิ์แก้ไขผู้ใช้งานในระดับเดียวกันหรือสูงกว่า');
            }
        }

        $request->validate([
            'email' => 'nullable|email|unique:users,email,' . $id,
            'username' => 'nullable|unique:users,username,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $updateData = [
            'titles' => $request->titles,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'username' => $request->username,
            'email' => $request->email,
            'updated_at' => now(),
        ];

        if ($currentAdmin->role === 'superadmin') {
            $updateData['role'] = $request->role;
        }

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('id', $id)->update($updateData);

        return redirect()->back()->with('success', 'อัปเดตข้อมูลสำเร็จ');
    }

    public function user_delete($userid)
    {
        $currentAdmin = DB::table('users')->where('id', Auth::id())->first();
        $targetUser = DB::table('users')->where('id', $userid)->first();

        if ($currentAdmin->id == $userid) {
            return redirect()->back()->with('error', 'คุณไม่สามารถลบบัญชีของตัวเองได้');
        }

        if ($currentAdmin->role !== 'superadmin') {
            if ($targetUser->role === 'superadmin' || $targetUser->role === 'admin') {
                return redirect()->back()->with('error', 'คุณไม่มีสิทธิ์ลบผู้ใช้งานในระดับเดียวกันหรือสูงกว่า');
            }
        }

        DB::table('users')->where('id', $userid)->delete();

        return redirect()->back()->with('success', 'ลบข้อมูลผู้ใช้งานเรียบร้อยแล้ว');
    }

    public function user_create()
    {

        return view('user.user_create');
    }
    public function user_store(Request $request)
    {

        if (Auth::user()->role !== 'superadmin') {
            return redirect()->route('user_manage')->with('error', 'คุณไม่มีสิทธิ์สร้างผู้ใช้งานใหม่');
        }

        $request->validate([
            'titles'    => 'required|string',
            'username'  => 'required|string|unique:users,username|max:255',
            'email'     => 'required|email|unique:users,email|max:100',
            'password'  => 'required|string|min:6',
            'role'      => 'required|in:superadmin,admin,user',
        ]);

         DB::table('users')->insert([
                'role'       => $request->role,
                'titles'     => $request->titles,
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'password'   => Hash::make($request->password),
                'username'   => $request->username,
                'created_at' => now(),
                'updated_at' => now(),
        ]);

        return redirect()->route('user_manage')->with('success', 'สร้างผู้ใช้งานใหม่เรียบร้อยแล้ว');
    }
}
