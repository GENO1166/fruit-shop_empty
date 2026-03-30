<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก - ร้านผลไม้สด</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #27ae60;
            --secondary-color: #f39c12;
            --bg-color: #f4f7f6;
            --white: #ffffff;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --danger: #e74c3c;
        }

        body {
            font-family: 'Kanit', sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px 0;
        }

        .register-container {
            background-color: var(--white);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .header h1 { color: var(--primary-color); margin: 0; font-size: 28px; }
        .header p { color: var(--text-light); margin-bottom: 25px; }

        .form-row { display: flex; gap: 15px; margin-bottom: 15px; }
        .form-group { text-align: left; margin-bottom: 15px; flex: 1; }
        
        label { display: block; margin-bottom: 5px; color: var(--text-dark); font-size: 14px; }
        
        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: 'Kanit', sans-serif;
            font-size: 15px;
            box-sizing: border-box;
        }

        .form-control:focus { outline: none; border-color: var(--primary-color); }

        .error-text { color: var(--danger); font-size: 12px; margin-top: 5px; }

        .register-button {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .register-button:hover { background-color: #219150; }

        .links { margin-top: 15px; font-size: 14px; }
        .links a { color: var(--secondary-color); text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

<div class="register-container">
    <div class="header">
        <h1>สมัครสมาชิก</h1>
        <p>ร่วมเป็นครอบครัวร้านผลไม้สดกับเรา</p>
    </div>

    <form action="{{ route('register') }}" method="POST">
        @csrf
        
        <div class="form-row">
            <div class="form-group" style="flex: 0.4;">
                <label>คำนำหน้า</label>
                <select name="titles" class="form-control">
                    <option value="นาย">นาย</option>
                    <option value="นาง">นาง</option>
                    <option value="นางสาว">นางสาว</option>
                </select>
            </div>
            <div class="form-group">
                <label>ชื่อจริง</label>
                <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
            </div>
            <div class="form-group">
                <label>นามสกุล</label>
                <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>ชื่อผู้ใช้งาน (Username)</label>
            <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
            @error('username') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>อีเมล</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>เบอร์โทรศัพท์</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" maxlength="10" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>รหัสผ่าน</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>ยืนยันรหัสผ่าน</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>
        @error('password') <div class="error-text">รหัสผ่านที่ป้อนไม่ตรงกัน</div> @enderror

        <button type="submit" class="register-button">ลงชื่อสมัครสมาชิก</button>
    </form>

    <div class="links">
        มีบัญชีอยู่แล้ว? <a href="{{ route('login') }}">เข้าสู่ระบบที่นี่</a>
    </div>
</div>

</body>
</html>