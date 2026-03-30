@extends('head.head_user')

@section('content')
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --bg-color: #f4f7f6;
            --border-color: #dcdde1;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Kanit', sans-serif;
        }

        .container {
            max-width: 850px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            color: var(--secondary-color);
            font-weight: 500;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .btn-back:hover {
            color: var(--primary-color);
            transform: translateX(-5px);
        }

        .form-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .form-card h2 {
            margin-bottom: 30px;
            color: var(--secondary-color);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--primary-color);
            margin-top: 25px;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #f0f0f0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #4a5568;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            font-size: 15px;
            box-sizing: border-box;
            outline: none;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
        }

        .form-control:disabled {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-row-3 {
            display: grid;
            grid-template-columns: 0.5fr 1fr 1fr;
            gap: 20px;
        }

        .btn-update {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            margin-top: 30px;
            transition: 0.3s;
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .error-text {
            color: var(--danger-color);
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .role-badge {
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 50px;
            background: #eee;
            margin-left: 10px;
        }
    </style>

    <div class="container">
        <a href="{{ route('user_manage') }}" class="btn-back">← ย้อนกลับไปยังรายชื่อผู้ใช้</a>

        <div class="form-card">
            <h2>
                <span>👤 แก้ไขข้อมูลผู้ใช้งาน</span>
                <span class="role-badge">{{ $user->role }}</span>
            </h2>

            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="section-title">ข้อมูลส่วนตัว</div>
                
                <div class="form-row-3">
                    <div class="form-group">
                        <label>คำนำหน้า</label>
                        <select name="titles" class="form-control" required>
                            <option value="นาย" {{ $user->titles == 'นาย' ? 'selected' : '' }}>นาย</option>
                            <option value="นาง" {{ $user->titles == 'นาง' ? 'selected' : '' }}>นาง</option>
                            <option value="นางสาว" {{ $user->titles == 'นางสาว' ? 'selected' : '' }}>นางสาว</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>ชื่อจริง</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}">
                    </div>

                    <div class="form-group">
                        <label>นามสกุล</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>เบอร์โทรศัพท์</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>          
                </div>

                <div class="section-title">ข้อมูลการเข้าสู่ระบบ</div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}">
                        @error('username') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Email (ใช้สำหรับกู้คืนรหัสผ่าน)</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                        @error('email') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>รหัสผ่านใหม่ (ปล่อยว่างถ้าไม่เปลี่ยน)</label>
                        <input type="password" name="password" class="form-control" placeholder="รหัสผ่านใหม่ 6 หลักขึ้นไป">
                        @error('password') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>สิทธิ์การใช้งาน (Role)</label>
                        <select name="role" class="form-control" {{ $admin->role !== 'superadmin' ? 'disabled' : '' }}>
                            @if($user->role == 'superadmin')
                                <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>Superadmin (ดูแลระบบสูงสุด)</option>
                            @endif
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin (ผู้ดูแล)</option>
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User (ผู้ใช้งานทั่วไป)</option>
                        </select>
                        @if($admin->role !== 'superadmin')
                            <small style="color: #999; font-size: 11px;">* เฉพาะ Superadmin เท่านั้นที่เปลี่ยนสิทธิ์ได้</small>
                            <input type="hidden" name="role" value="{{ $user->role }}">
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn-update">บันทึกการเปลี่ยนแปลง</button>
            </form>
        </div>
    </div>
@endsection