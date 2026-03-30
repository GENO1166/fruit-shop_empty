@extends('head.head_user')

@section('content')
<style>
    .hero-section {
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        color: white;
        padding: 30px 0;
        border-radius: 0 0 50px 50px;
        margin-bottom: 50px;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    .feature-card {
        border: none;
        border-radius: 20px;
        transition: 0.3s;
        background: #fff;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }

    .feature-icon {
        font-size: 3rem;
        color: #27ae60;
        margin-bottom: 20px;
    }

    .btn-hero {
        background-color: white;
        color: #27ae60;
        font-weight: 600;
        padding: 12px 35px;
        border-radius: 50px;
        text-decoration: none;
        transition: 0.3s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .btn-hero:hover {
        background-color: #f8f9fa;
        color: #219150;
        transform: scale(1.05);
    }

    .custom-alert {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
</style>

<div class="container mt-4">
<section class="hero-section text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="hero-title mb-3">ยินดีต้อนรับสู่ <span style="color: #ffde59;">FreshFruit</span></h1>
                <p class="lead mb-5 opacity-90">
                    "คัดจากสวน ส่งตรงถึงบ้านคุณ ผลไม้พรีเมียม สดใหม่ทุกวัน"
                </p>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="card h-100 p-4 feature-card shadow-sm">
                <div class="feature-icon">
                    <i class="bi bi-tree"></i>
                </div>
                <h4 class="fw-bold">สดจากสวน</h4>
                <p class="text-muted">ผลไม้ทุกลูกคัดสรรจากสวนคุณภาพ ปลอดสารพิษ และเก็บเกี่ยวตามฤดูกาล</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 p-4 feature-card shadow-sm">
                <div class="feature-icon">
                    <i class="bi bi-truck"></i>
                </div>
                <h4 class="fw-bold">ส่งไวทันใจ</h4>
                <p class="text-muted">บริการจัดส่งรวดเร็วถึงหน้าบ้านคุณภายในวันเดียว เพื่อคงความสดใหม่ที่สุด</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 p-4 feature-card shadow-sm">
                <div class="feature-icon">
                    <i class="bi bi-award"></i>
                </div>
                <h4 class="fw-bold">รับประกันคุณภาพ</h4>
                <p class="text-muted">ไม่พอใจยินดีเปลี่ยนคืน เราใส่ใจในความพึงพอใจของลูกค้าเป็นอันดับหนึ่ง</p>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="bg-light rounded-5 p-5 text-center shadow-sm">
        <h2 class="fw-bold mb-3">ค้นพบรสชาติที่แท้จริงของธรรมชาติ</h2>
        <p class="text-muted mb-4">เรามีผลไม้ให้เลือกมากกว่า 50 รายการ พร้อมโปรโมชั่นพิเศษสำหรับสมาชิก</p>
        <a href="#" class="btn btn-success btn-lg px-5 rounded-pill shadow">
            ดูสินค้าทั้งหมด
        </a>
    </div>
</div>
@endsection