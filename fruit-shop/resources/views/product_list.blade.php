@extends('head.head_user')

@section('content')
    <style>
        :root {
            --primary-color: #27ae60;
            --secondary-color: #f39c12;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Kanit', sans-serif;
        }

        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            background: #fff;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
        }

        .product-img-container {
            height: 220px;
            overflow: hidden;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .price-tag {
            color: var(--primary-color);
            font-size: 1.3rem;
            font-weight: 600;
        }

        .cart-form {
            position: relative;
            z-index: 10;
        }

        .qty-input {
            max-width: 60px;
            text-align: center;
            border: 1px solid #eee;
            border-radius: 50px 0 0 50px !important;
        }

        .buy-button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0 50px 50px 0 !important;
            transition: 0.2s;
            padding: 5px 15px;
        }

        .buy-button:hover {
            background-color: #219150;
            color: white;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark">ร้านผลไม้สด - Fresh Fruit Shop</h2>
            <p class="text-muted">คัดสรรผลไม้คุณภาพดี ส่งตรงจากสวนถึงมือคุณ</p>
        </div>
        
        <div class="row mb-5 justify-content-center">
            <div class="col-md-7">
                <form action="{{ url()->current() }}" method="GET" class="d-flex shadow-sm" style="border-radius: 50px; overflow: hidden;">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 p-3 ps-4" placeholder="ค้นหาผลไม้ที่ต้องการ...">
                    <button class="btn btn-success px-4" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm product-card">
                        @if ($product->status == 'out_of_stock')
                            <div class="position-absolute top-0 end-0 m-3" style="z-index: 5;">
                                <span class="badge rounded-pill bg-danger shadow-sm">สินค้าหมด</span>
                            </div>
                        @endif

                        <div class="product-img-container">
                            @if ($product->image)
                                <img src="{{ asset('public/storage/product_images/' . $product->image) }}" class="img-fluid"
                                    alt="{{ $product->product_name }}"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div class="text-center text-muted">
                                    <i class="bi bi-box-seam" style="font-size: 3rem;"></i>
                                    <p class="small mb-0">ไม่มีรูปภาพ</p>
                                </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark mb-1">{{ $product->product_name }}</h5>
                            <p class="card-text text-muted small flex-grow-1">
                                {{ $product->description }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="price-tag">฿{{ number_format($product->price, 0) }}</span>

                                @if ($product->status == 'active')
                                    <form action="{{ route('add.product', $product->id) }}" method="POST" class="cart-form">
                                        @csrf
                                        <div class="input-group input-group-sm">
                                            <input type="number" name="product_quantity" value="1" min="1" class="form-control qty-input">
                                            <button type="submit" name="action" value="add" class="btn buy-button">
                                                <i class="bi bi-cart-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <a href="#" class="stretched-link" style="z-index: 1;"></a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">ไม่พบสินค้าที่คุณต้องการ</h4>
                    <a href="{{ url()->current() }}" class="btn btn-outline-success mt-2 rounded-pill">ดูสินค้าทั้งหมด</a>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $products->appends(request()->input())->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection