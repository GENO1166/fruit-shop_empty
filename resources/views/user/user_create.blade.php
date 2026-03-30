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

        .btn-submit {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
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

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }

        .error-text {
            color: var(--danger-color);
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }
    </style>

    <div class="container">
        <a href="{{ route('user_manage', Auth::id()) }}" class="btn-back">← ย้อนกลับ</a>

        <div class="form-card">
            <h2>สร้างผู้ใช้งานใหม่</h2>
            
            <form action="{{ route('user.store', Auth::id()) }}" method="POST">
                @csrf

                <div class="section-title">ข้อมูลส่วนตัว</div>
                
                <div class="form-row-3">
                    <div class="form-group">
                        <label>คำนำหน้า <span class="text-danger">*</span></label>
                        <select name="titles" class="form-control" required>
                            <option value="">เลือก...</option>
                            <option value="นาย">นาย</option>
                            <option value="นาง">นาง</option>
                            <option value="นางสาว">นางสาว</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>ชื่อจริง</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" placeholder="กรุณากรอกชื่อจริง">
                    </div>

                    <div class="form-group">
                        <label>นามสกุล</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" placeholder="กรุณากรอกนามสกุล">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>เบอร์โทรศัพท์</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="08x-xxxxxxx">
                    </div>
                </div>

                <div class="section-title">ข้อมูลการเข้าสู่ระบบ</div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" value="{{ old('username') }}" required placeholder="ตั้งชื่อผู้ใช้งาน">
                        @error('username') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="example@email.com">
                        @error('email') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>รหัสผ่าน <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required placeholder="กำหนดรหัสผ่าน 6 หลักขึ้นไป">
                        @error('password') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>สิทธิ์การใช้งาน (Role) <span class="text-danger">*</span></label>
                        <select name="role" class="form-control" required>
                            <option value="user" selected>User (ผู้ใช้งานทั่วไป)</option>
                            <option value="admin">Admin (ผู้ดูแล)</option>
                            <option value="superadmin">Superadmin (ผู้ดูแลระบบสูงสุด)</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-submit">ยืนยันการสร้างผู้ใช้งาน</button>
            </form>
        </div>
    </div>
@endsection