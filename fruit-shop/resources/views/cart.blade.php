@extends('head.head_user')

@section('content')
    <style>
        :root {
            --primary-color: #27ae60;
            --secondary-color: #2c3e50;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Kanit', sans-serif;
        }

        .cart-header {
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .cart-item-card {
            background: white;
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .cart-item-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            background: #f1f2f6;
            border-radius: 50px;
            padding: 5px 15px;
            width: fit-content;
        }

        .btn-qty {
            background: none;
            border: none;
            color: var(--primary-color);
            font-weight: bold;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0 10px;
        }

        .qty-input {
            width: 40px;
            text-align: center;
            border: none;
            background: transparent;
            font-weight: 600;
        }

        .price-text {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .summary-card {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 100px;
        }

        .btn-checkout {
            background: var(--primary-color);
            color: white;
            border-radius: 50px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            border: none;
            transition: 0.3s;
        }

        .btn-checkout:hover {
            background: #219150;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
            color: white;
        }

        .btn-remove {
            color: #e74c3c;
            cursor: pointer;
            transition: 0.2s;
            background: none;
            border: none;
        }

        .btn-remove:hover {
            color: #c0392b;
            transform: scale(1.1);
        }
    </style>

    <div class="container py-5">
        <div class="cart-header d-flex align-items-center">
            <h2 class="fw-bold mb-0"><i class="bi bi-cart3 me-2"></i> ตะกร้าสินค้าของคุณ</h2>
            <span class="ms-3 text-muted">({{ count($cartItems) }} รายการ)</span>
        </div>

        @if (count($cartItems) > 0)
            <div class="row">
                <div class="col-lg-8">
                    @foreach ($cartItems as $item)
                        <div class="card cart-item-card p-3">
                            <div class="row align-items-center">
                                <div class="col-4 col-md-2 text-center">
                                    @if ($item->image)
                                        <img src="{{ asset('public/storage/product_images/' . $item->image) }}"
                                            class="cart-item-img" alt="Product">
                                    @else
                                        <div class="cart-item-img bg-light d-flex align-items-center justify-content-center"
                                            style="font-size: 2rem;">🍏</div>
                                    @endif
                                </div>
                                <div class="col-8 col-md-4">
                                    <h5 class="fw-bold mb-1">{{ $item->product_name }}</h5>
                                    <p class="text-muted small mb-0">ราคาต่อหน่วย: ฿{{ number_format($item->price, 2) }}</p>
                                </div>
                                <div class="col-6 col-md-3 mt-3 mt-md-0">
                                    <div class="quantity-control mx-auto mx-md-0">
                                        <form action="{{ route('cart.quantity', [$usercart->id, $item->product_id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="action" value="decrease">
                                            <button type="submit" class="btn-qty">-</button>
                                        </form>

                                        <input type="text" class="qty-input" value="{{ $item->quantity }}" readonly>

                                        <form action="{{ route('cart.quantity', [$usercart->id, $item->product_id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="action" value="increase">
                                            <button type="submit" class="btn-qty">+</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2 text-end mt-3 mt-md-0">
                                    <span class="price-text">฿{{ number_format($item->price * $item->quantity, 2) }}</span>
                                </div>
                                <div class="col-2 col-md-1 text-end mt-3 mt-md-0">
                                    <form action="{{ route('cart.remove', [$usercart->id, $item->product_id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove"
                                            onclick="return confirm('ยืนยันการลบสินค้านี้?')">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="card summary-card p-4">
                        <h4 class="fw-bold mb-4">สรุปคำสั่งซื้อ</h4>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">ยอดรวมสินค้า</span>
                            <span>฿{{ number_format($total, 2) }}</span>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="fw-bold">ยอดชำระสุทธิ</h5>
                            <h5 class="fw-bold text-success">฿{{ number_format($total, 2) }}</h5>
                        </div>

                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/11329/11329060.png" width="150" class="mb-4 opacity-50">
                <h3 class="fw-bold text-muted">ตะกร้าสินค้าว่างเปล่า</h3>
                <p class="text-muted">ดูเหมือนว่าคุณยังไม่ได้เลือกผลไม้ใส่ตะกร้าเลย</p>
                <a href="{{ route('products_list') }}" class="btn btn-success px-5 py-2 rounded-pill mt-3">
                    ไปเลือกซื้อผลไม้สดๆ กัน!
                </a>
            </div>
        @endif
    </div>
@endsection
