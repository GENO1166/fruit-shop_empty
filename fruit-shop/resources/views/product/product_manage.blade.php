@extends('head.head_user')

@section('content')
    <style>
        :root {
            --primary-color: #27ae60;
            --secondary-color: #2c3e50;
            --danger-color: #c0392b;
            --report-color: #34495e;
            --bg-color: #ffffff;
            --border-color: #eeeeee;
        }

        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border: 1px solid var(--border-color);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
        }

        .table-header h2 {
            margin: 0;
            color: var(--secondary-color);
            font-size: 24px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .btn-add {
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-add:hover {
            background-color: #219150;
            transform: translateY(-2px);
        }

        .btn-report {
            background-color: var(--report-color);
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .btn-report:hover {
            background-color: #2c3e50;
            transform: translateY(-2px);
            color: #ecf0f1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #f8f9fa;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 2px solid #ddd;
            color: #555;
            font-size: 14px;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .price-tag {
            font-weight: 600;
            color: #e67e22;
        }

        .fruit-icon {
            width: 60px;
            height: 60px;
            object-fit: cover;
            object-position: center;
            background: #f0f0f0;
            border-radius: 8px;
            margin-right: 15px;
            flex-shrink: 0;
            border: 1px solid #eee;
        }

        div.fruit-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .action-btns {
            display: flex;
            gap: 5px;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 3px;
            text-decoration: none;
            font-size: 13px;
            border: 1px solid #ddd;
            background: white;
            cursor: pointer;
        }

        .btn-edit {
            color: #2980b9;
        }

        .btn-edit:hover {
            background-color: #f0f7ff;
        }

        .btn-delete {
            color: var(--danger-color);
        }

        .btn-delete:hover {
            background-color: #fff5f5;
        }

        .status-badge-a {
            background: #eafaf1;
            color: #1e8449;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #2ecc71;
            display: inline-block;
        }

        .status-badge-i {
            background: #fdf2f2;
            color: #c53030;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #f56565;
            display: inline-block;
        }

        .status-badge-o {
            background: #fef3c7;
            color: #92400e;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #f6e05e;
            display: inline-block;
        }
    </style>

    <div class="container">

        @if (session('success'))
            <div style="background-color: #27ae60; color: white; padding: 10px 15px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div style="background-color: #e74c3c; color: white; padding: 10px 15px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-header">
            <h2>จัดการรายการผลไม้</h2>
            
            <div class="header-actions">
                @if ($user_role->role !== 'user')
                    <a href="{{ route('products.pdf') }}" target="_blank" class="btn-report">
                        📄 ออกรายงาน (PDF)
                    </a>

                    <a href="{{ route('products_create') }}" class="btn-add">
                        + เพิ่มผลไม้ใหม่
                    </a>
                @endif
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="80">รหัส</th>
                    <th>รายละเอียดผลไม้</th>
                    <th width="80">จำนวน</th>
                    <th width="200">ราคา/หน่วย</th>
                    <th width="150">สถานะ</th>
                    <th width="150" style="text-align: center;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>#{{ $product->id }}</td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                @if ($product->image)
                                    <img class="fruit-icon" src="{{ asset('public/storage/product_images/' . $product->image) }}" alt="Product Image">
                                @else
                                    <div class="fruit-icon">🍏</div>
                                @endif
                                <div>
                                    <div style="font-weight: 600;">{{ $product->product_name }}</div>
                                    <div style="font-size: 12px; color: #777;">
                                        {{ Str::limit($product->description, 50) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            <span class="price-tag">{{ number_format($product->price, 2) }} บาท</span>
                        </td>
                        <td>
                            @if ($product->status === 'active')
                                <span class="status-badge-a">พร้อมขาย</span>
                            @elseif ($product->status === 'inactive')
                                <span class="status-badge-i">ไม่พร้อมขาย</span>
                            @else
                                <span class="status-badge-o">สินค้าหมด</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns" style="justify-content: center;">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn-action btn-edit">แก้ไข</a>

                                <form action="{{ route('products.delete', $product->id) }}" method="POST"
                                    onsubmit="return confirm('ยืนยันการลบรายการนี้?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete">ลบ</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection