<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ - ร้านผลไม้สด</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #27ae60;
            --secondary-color: #f39c12;
            --bg-color: #f4f7f6;
            --white: #ffffff;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
        }

        body {
            font-family: 'Kanit', sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            background-color: var(--white);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-header {
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: var(--primary-color);
            margin: 0;
            font-size: 32px;
        }

        .login-header p {
            color: var(--text-light);
            margin-top: 5px;
        }

        .fruit-icon {
            font-size: 50px;
            margin-bottom: 10px;
            display: block;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-dark);
            font-weight: 400;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: 'Kanit', sans-serif;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 5px rgba(39, 174, 96, 0.2);
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Kanit', sans-serif;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .login-button:hover {
            background-color: #219150;
        }

        .extra-links {
            margin-top: 20px;
            font-size: 14px;
            color: var(--text-light);
        }

        .extra-links a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .extra-links a:hover {
            text-decoration: underline;
        }

        .back-home {
            display: inline-block;
            margin-top: 20px;
            color: var(--text-light);
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            @if (session('success'))
                <div
                    style="background-color: #27ae60; color: white; padding: 10px 15px; border-radius: 5px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div
                    style="background-color: #e74c3c; color: white; padding: 10px 15px; border-radius: 5px; margin-bottom: 20px;">
                    {{ session('error') }}
                </div>
            @endif
            <h1>เข้าสู่ระบบ</h1>
            <p>ยินดีต้อนรับสู่ร้านผลไม้สดของเรา</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="login">อีเมล / ชื่อผู้ใช้งาน</label>
                <input type="text" id="login" name="login" class="form-control" placeholder="example@mail.com"
                    required>
            </div>

            <div class="form-group">
                <label for="password">รหัสผ่าน</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="ระบุรหัสผ่าน"
                    required>
            </div>

            <button type="submit" class="login-button">เข้าสู่ระบบ</button>
        </form>

        <div class="extra-links">
            ยังไม่มีบัญชี? <a href="{{ route('register') }}">สมัครสมาชิกใหม่</a>
        </div>

        <a href="{{ route('homepage') }}" class="back-home">← กลับไปหน้าหลัก</a>
    </div>

</body>

</html>
