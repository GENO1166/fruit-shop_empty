@extends('head.head_user')

@section('content')
    <style>
        :root {
            --primary-color: #27ae60;
            --secondary-color: #2c3e50;
            --bg-color: #f4f7f6;
            --border-color: #dcdde1;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Poppins', 'Sarabun', sans-serif;
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
            transition: all 0.3s ease;
            outline: none;
            background-color: #fcfcfc;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            background-color: white;
            box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .price-input-wrapper {
            position: relative;
        }

        .price-input-wrapper span {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
            font-weight: 500;
        }

        .image-upload-box {
            border: 2px dashed var(--border-color);
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .image-upload-box:hover {
            border-color: var(--primary-color);
            background: rgba(39, 174, 96, 0.02);
        }

        .btn-submit {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.2);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(39, 174, 96, 0.3);
        }

        .error-text {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .is-invalid {
            border-color: #e74c3c !important;
        }
    </style>

    <div class="container">
        <a href="{{ route('products_manage') }}" class="btn-back">
            ← ย้อนกลับไปหน้ารายการสินค้า
        </a>

        <div class="form-card">
            <h2>เพิ่มสินค้าใหม่</h2>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="product_name">ชื่อสินค้า <span style="color: red;">*</span></label>
                        <input type="text" name="product_name" id="product_name"
                            class="form-control @error('product_name') is-invalid @enderror" placeholder="เช่น แอปเปิ้ลฟูจิ"
                            value="{{ old('product_name') }}" required>
                        @error('product_name')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">ราคา <span style="color: red;">*</span></label>
                        <div class="price-input-wrapper">
                            <input type="number" name="price" id="price" step="0.01"
                                class="form-control @error('price') is-invalid @enderror" placeholder="0.00"
                                value="{{ old('price') }}" required>
                            <span>บาท</span>
                        </div>
                        @error('price')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">รายละเอียดสินค้า</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                        placeholder="ระบุข้อมูลสินค้าเพิ่มเติม...">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status">สถานะสินค้า <span style="color: red;">*</span></label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                        required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>วางขาย (Active)</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>ปิดการขาย (Inactive)
                        </option>
                    </select>
                    @error('status')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>รูปภาพสินค้า <span style="color: red;">*</span></label>
                    <div class="image-upload-box @error('product_image') is-invalid @enderror"
                        onclick="document.getElementById('product_image').click();"
                        style="@error('product_image') border-color: #e74c3c; @enderror">

                        <span id="file-name" style="color: #718096;">
                            {{ old('product_image') ? 'เลือกรูปภาพแล้ว' : 'คลิกเพื่อเลือกรูปภาพ หรือลากมาวางที่นี่' }}
                        </span>

                        <input type="file" name="product_image" id="product_image" style="display: none;"
                            onchange="document.getElementById('file-name').innerText = this.files[0].name">
                    </div>

                    @error('product_image')
                        <span class="error-text" style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    บันทึกข้อมูลสินค้า
                </button>
            </form>
        </div>
    </div>
@endsection
