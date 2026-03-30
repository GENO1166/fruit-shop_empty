<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ storage_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ storage_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ storage_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ storage_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: 'THSarabunNew', sans-serif;
            font-size: 16px;
            color: #333;
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        .header-table {
            width: 100%;
            border-bottom: 2px solid #27ae60;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .title {
            font-size: 26px;
            font-weight: bold;
            color: #2c3e50;
        }

        .date-info {
            text-align: right;
            font-size: 14px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 10px;
            font-weight: bold;
            text-align: center;
            font-size: 14px;
        }

        td {
            border: 1px solid #eee;
            padding: 8px;
            vertical-align: middle;
            font-size: 14px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .fruit-img {
            width: 40px;
            height: 40px;
            border-radius: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>

<body>

    <table class="header-table">
        <tr>
            <td style="border:none;" class="title">{{ $title }}</td>
            <td style="border:none;" class="date-info">
                วันที่พิมพ์: {{ $date }}<br>
                จำนวนรายการทั้งหมด: {{ count($products) }} รายการ
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th width="8%">รหัส</th>
                <th width="10%">รูป</th>
                <th>รายละเอียดผลไม้</th>
                <th width="10%">จำนวน</th>
                <th width="18%">ราคา/หน่วย</th>
                <th width="15%">สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td class="text-center">#{{ $product->id }}</td>
                    <td class="text-center">
                        @if ($product->image && file_exists(public_path('storage/product_images/' . $product->image)))
                            <img class="fruit-img" src="{{ public_path('storage/product_images/' . $product->image) }}">
                        @else
                            <span style="font-size: 20px;">🍏</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: bold;">{{ $product->product_name }}</div>
                        <div style="font-size: 11px; color: #666;">{{ Str::limit($product->description, 70) }}</div>
                    </td>
                    <td class="text-center">{{ number_format($product->quantity) }}</td>
                    <td class="text-right">
                        <span>{{ number_format($product->price, 2) }} บาท</span>
                    </td>
                    <td class="text-center">
                        @if ($product->status === 'active')
                            <span>พร้อมขาย</span>
                        @elseif ($product->status === 'inactive')
                            <span>ไม่พร้อมขาย</span>
                        @else
                            <span>สินค้าหมด</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        ออกรายงานโดยระบบจัดการผลไม้ - หน้าที่ 1/1
    </div>

</body>

</html>
