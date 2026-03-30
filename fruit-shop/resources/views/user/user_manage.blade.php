@extends('head.head_user')

@section('content')
    <style>
        :root {
            --primary-color: #27ae60;
            --secondary-color: #2c3e50;
            --danger-color: #e74c3c;
            --admin-color: #3498db;
            --super-color: #9b59b6;
            --border-color: #eeeeee;
        }

        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f4f7f6;
        }

        .container-box {
            max-width: 1200px;
            margin: 30px auto;
            padding: 25px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .table-header h2 {
            margin: 0;
            color: var(--secondary-color);
            font-size: 22px;
            font-weight: 600;
        }

        .btn-add {
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-add:hover {
            background-color: #219150;
            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: left;
            color: #7f8c8d;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f1f1f1;
            vertical-align: middle;
            color: #2c3e50;
        }

        .role-badge {
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .role-superadmin { background: #f5eef8; color: var(--super-color); border: 1px solid var(--super-color); }
        .role-admin { background: #ebf5fb; color: var(--admin-color); border: 1px solid var(--admin-color); }
        .role-user { background: #f2f4f4; color: #7f8c8d; border: 1px solid #bdc3c7; }

        .status-active { color: #27ae60; }
        .status-inactive { color: #e74c3c; }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: #f0f2f5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-right: 12px;
            color: #95a5a6;
        }

        .btn-action {
            padding: 6px 10px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 18px;
            transition: 0.2s;
            border: none;
            background: none;
            cursor: pointer;
        }
        .btn-edit { color: var(--admin-color); }
        .btn-edit:hover { background: #ebf5fb; }
        .btn-delete { color: var(--danger-color); }
        .btn-delete:hover { background: #fdf2f2; }

        .user-info p { margin: 0; }
        .user-name { font-weight: 600; font-size: 15px; }
        .user-email { font-size: 13px; color: #95a5a6; }
    </style>

    <div class="container-box">
        <div class="table-header">
            <h2><i class="bi bi-people-fill me-2"></i> จัดการสมาชิกระบบ</h2>
            @if($user_role->role == 'superadmin')
                <a href="{{ route('user.create') }}" class="btn-add">+ เพิ่มสมาชิกใหม่</a>
            @endif
        </div>

        <table>
            <thead>
                <tr>
                    <th width="80">ID</th>
                    <th>ข้อมูลสมาชิก</th>
                    <th>บทบาท</th>
                    <th>การติดต่อ</th>
                    <th style="text-align: center;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userdata as $user)
                    <tr>
                        <td><span class="text-muted">#{{ $user->id }}</span></td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <div class="user-avatar">
                                    <i class="bi bi-person-circle"></i>
                                </div>
                                <div class="user-info">
                                    <div class="user-name">
                                        {{ $user->titles }}{{ $user->first_name }} {{ $user->last_name }}
                                    </div>
                                    <div class="user-email">@ {{ $user->username ?? 'ไม่มีชื่อผู้ใช้' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->role == 'superadmin')
                                <span class="role-badge role-superadmin">Super Admin</span>
                            @elseif($user->role == 'admin')
                                <span class="role-badge role-admin">Admin</span>
                            @else
                                <span class="role-badge role-user">User</span>
                            @endif
                        </td>
                        <td>
                            <div style="font-size: 13px;">
                                <i class="bi bi-envelope text-muted me-1"></i> {{ $user->email }}<br>
                                <i class="bi bi-telephone text-muted me-1"></i> {{ $user->phone }}
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; justify-content: center; gap: 10px;">
                                <a href="{{ route('user.edit', $user->id) }}" class="btn-action btn-edit" title="แก้ไข">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('user.delete', $user->id) }}" method="POST" onsubmit="return confirm('ยืนยันการลบสมาชิกรายนี้?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="ลบ">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection