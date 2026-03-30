@extends('head.head_user')

@section('content')
    <style>
        :root {
            --primary-color: #27ae60;
            --secondary-color: #2ecc71;
        }

        body {
            background-color: #f4f7f6;
        }

        .profile-card {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .profile-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 15px;
            color: var(--primary-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #eee;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25 row rgba(39, 174, 96, 0.1);
        }

        .section-title {
            border-left: 5px solid var(--primary-color);
            padding-left: 15px;
            margin-bottom: 25px;
            font-weight: 700;
            color: #2c3e50;
        }

        .btn-save {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
            width: 100%;
        }

        .btn-save:hover {
            background-color: #219150;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }

        .input-group-text {
            background: transparent;
            border-right: none;
            color: #aaa;
        }

        .form-control.with-icon {
            border-left: none;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4 rounded-3">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    </div>
                @endif

                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <h3 class="mb-0 fw-bold">{{ Auth::user()->name }}</h3>
                        <p class="mb-0 opacity-75">จัดการข้อมูลส่วนตัวและรหัสผ่านของคุณ</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('profile.edit', Auth::id()) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <h5 class="section-title">ข้อมูลส่วนตัว</h5>
                            <div class="row g-3 mb-5">
                                <div class="col-md-2">
                                    <label class="form-label">คำนำหน้า</label>
                                    <select name="titles" class="form-control" required>
                                        <option value="นาย"
                                            {{ old('titles', $userdata->titles) == 'นาย' ? 'selected' : '' }}>นาย</option>
                                        <option value="นาง"
                                            {{ old('titles', $userdata->titles) == 'นาง' ? 'selected' : '' }}>นาง</option>
                                        <option value="นางสาว"
                                            {{ old('titles', $userdata->titles) == 'นางสาว' ? 'selected' : '' }}>นางสาว
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">ชื่อ</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="first_name"
                                            class="form-control with-icon @error('first_name') is-invalid @enderror"
                                            value="{{ old('first_name', $userdata->first_name) }}">
                                    </div>

                                </div>

                                <div class="col-md-5">
                                    <label class="form-label">นามสกุล</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="last_name"
                                            class="form-control with-icon @error('last_name') is-invalid @enderror"
                                            value="{{ old('last_name', $userdata->last_name) }}">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">อีเมล</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="email" class="form-control with-icon"
                                            value="{{ old('email', $userdata->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">เบอร์โทรศัพท์</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="text" name="phone" class="form-control with-icon"
                                            value="{{ old('phone', $userdata->phone) }}" placeholder="08x-xxx-xxxx">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-save">
                                <i class="bi bi-save me-2"></i> บันทึกการเปลี่ยนแปลง
                            </button>
                        </form>

                        <form action="{{ route('profile.change_password', Auth::id()) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <h5 class="section-title mt-5">ความปลอดภัย (เปลี่ยนรหัสผ่าน)</h5>
                            <div class="row g-3 mb-4">
                                <div class="col-md-12">
                                    <label class="form-label">รหัสผ่านปัจจุบัน</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                        <input type="password" name="current_password"
                                            class="form-control with-icon"
                                            placeholder="ระบุรหัสผ่านเดิมเพื่อยืนยันการเปลี่ยน">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">รหัสผ่านใหม่</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                                        <input type="password" name="new_password"
                                            class="form-control with-icon"
                                            placeholder="รหัสผ่านใหม่">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">ยืนยันรหัสผ่านใหม่</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                        <input type="password" name="new_password_confirmation"
                                            class="form-control with-icon" placeholder="ยืนยันรหัสผ่านใหม่">
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-save">
                                    <i class="bi bi-save me-2"></i> แก้ไขรหัสผ่าน
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
