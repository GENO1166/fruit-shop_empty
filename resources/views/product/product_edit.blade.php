@extends('head.head_user')

@section('content')
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --bg-color: #f4f7f6;
            --border-color: #dcdde1;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Kanit', sans-serif;
        }

        .container {
            max-width: 800px;
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

        /* สไตล์สำหรับรูปภาพเดิม */
        .current-image-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #eee;
            margin-bottom: 10px;
        }

        .image-upload-box {
            border: 2px dashed var(--border-color);
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            background: #fafafa;
            cursor: pointer;
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
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .error-text {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }
    </style>

    <div class="container">
        <a href="{{ route('products_manage') }}" class="btn-back">← ย้อนกลับ</a>

        <div class="form-card">
            <h2>แก้ไขข้อมูลสินค้า</h2>
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>ชื่อสินค้า</label>
                    <input type="text" name="product_name" class="form-control" value="{{ $product->product_name }}"
                        required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>ราคา (บาท)</label>
                        <input type="number" name="price" step="0.01" class="form-control"
                            value="{{ $product->price }}" required>
                    </div>

                    <div class="form-group">
                        <label>สถานะ</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>พร้อมขาย</option>
                            <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>ปิดการขาย
                            </option>
                            <option value="out_of_stock" {{ $product->status == 'out_of_stock' ? 'selected' : '' }}>
                                สินค้าหมด</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>รายละเอียดสินค้า</label>
                    <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                </div>

                <div class="form-group">
                    <label>รูปภาพสินค้า</label>
                    <div style="display: flex; align-items: flex-start;">
                        <div>
                            @if ($product->image)
                                <img src="{{ asset('public/storage/product_images/' . $product->image) }}"
                                    alt="Product Image" width="100">
                            @endif
                        </div>

                        <div style="flex-grow: 1;">
                            <p style="font-size: 12px; color: #666;">อัปโหลดรูปใหม่ (ถ้าต้องการเปลี่ยน):</p>
                            <div class="image-upload-box" onclick="document.getElementById('product_image').click();">
                                <span id="file-name">📸 คลิกเพื่อเลือกรูปใหม่</span>
                                <input type="file" name="product_image" id="product_image" style="display: none;"
                                    onchange="document.getElementById('file-name').innerText = this.files[0].name">
                            </div>
                        </div>
                    </div>
                    @error('product_image')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-update">อัปเดตข้อมูลสินค้า</button>
            </form>
        </div>
    </div>
@endsection
