<style>
    .navbar-custom {
        background-color: #1e272e;
        height: 70px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 5%;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .nav-logo {
        color: white;
        font-size: 24px;
        font-weight: 700;
        text-decoration: none;
        letter-spacing: 1px;
    }

    .nav-logo span {
        color: #27ae60;
    }

    .nav-links {
        display: flex;
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
        height: 100%;
    }

    .nav-item {
        color: #bdc3c7;
        text-decoration: none;
        padding: 0 18px;
        font-size: 15px;
        font-weight: 400;
        transition: all 0.3s ease;
        height: 70px;
        display: flex;
        align-items: center;
    }

    .nav-item:hover {
        color: #27ae60;
    }

    .nav-item.active {
        color: #ffffff;
        font-weight: 600;
        border-bottom: 3px solid #27ae60;
    }

    .dropdown-container {
        position: relative;
        height: 100%;
        display: flex;
        align-items: center;
    }

    .drop-btn {
        cursor: pointer;
        background: none;
        border: none;
        color: #bdc3c7;
        font-family: inherit;
        font-size: 15px;
        padding: 0 15px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background-color: #ffffff;
        min-width: 180px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        border-radius: 0 0 8px 8px;
        overflow: hidden;
        animation: fadeIn 0.2s ease-out;
        z-index: 1001;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-container:hover .dropdown-content {
        display: block;
    }

    .dropdown-container:hover .drop-btn {
        color: white;
    }

    .dropdown-content a {
        color: #2d3436;
        padding: 12px 20px;
        text-decoration: none;
        display: block;
        font-size: 14px;
        transition: background 0.2s;
        border-bottom: 1px solid #f1f1f1;
    }

    .dropdown-content a:hover {
        background-color: #f8f9fa;
        color: #27ae60;
    }

    .login-btn-custom {
        background-color: #27ae60;
        color: white !important;
        padding: 8px 20px !important;
        border-radius: 50px;
        margin-left: 10px;
        font-weight: 600 !important;
    }

    .login-btn-custom:hover {
        background-color: #219150;
        box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
    }

    .cart-container {
        position: relative;
        display: flex;
        align-items: center;
        margin-right: 10px;
    }

    .cart-icon {
        font-size: 20px;
        color: #bdc3c7;
        transition: 0.3s;
        position: relative;
        padding: 10px;
    }

    .cart-container:hover .cart-icon {
        color: #27ae60;
    }

    .cart-badge {
        position: absolute;
        top: 2px;
        right: 2px;
        background-color: #e74c3c;
        color: white;
        font-size: 10px;
        font-weight: bold;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #1e272e;
    }
</style>

<nav class="navbar-custom">
    <a href="{{ route('homepage') }}" class="nav-logo">
        <i class="bi bi-basket-fill"></i> Fresh<span>Fruit</span>
    </a>

    <div class="nav-links">
        <div class="cart-container">
             @if (Auth::check())
            <a href="{{ route('cart', Auth::id()) }}" class="cart-icon nav-item {{ request()->routeIs('cart') ? 'active' : '' }}">
                <i class="bi bi-cart3"></i>
                @php
                    $cartCount = count(session('cart', []));
                @endphp
                @if ($cartCount > 0)
                    <span class="cart-badge">{{ $cartCount }}</span>
                @endif
            </a>
            @else
            <a href="{{ route('login') }}" class="cart-icon">
                <i class="bi bi-cart3"></i>
            @endif
        </div>
        
        <a href="{{ route('homepage') }}" class="nav-item {{ request()->routeIs('homepage') ? 'active' : '' }}">
            หน้าแรก
        </a>

        <a href="{{ route('products_list') }}"
            class="nav-item {{ request()->routeIs('products_list') ? 'active' : '' }}">
            รายการสินค้า
        </a>

        @if (Auth::check() && Auth::user()->role !== 'user')
            <a href="{{ route('products_manage') }}"
                class="nav-item {{ request()->routeIs('products_manage') ? 'active' : '' }}">
                จัดการสินค้า
            </a>

            <a href="{{ route('user_manage') }}"
                class="nav-item {{ request()->routeIs('user_manage') ? 'active' : '' }}">
                จัดการผู้ใช้งาน
            </a>
        @endif

        @if (Auth::check())
            <div class="dropdown-container">
                <div class="nav-item drop-btn">
                    <i class="bi bi-person-circle"></i>
                    {{ Auth::user()->first_name }} <small>▼</small>
                </div>
                <div class="dropdown-content">
                    <a href="{{ route('profile_edit', Auth::id()) }}"><i class="bi bi-person"></i> ข้อมูลส่วนตัว</a>

                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        style="color: #e74c3c; border-top: 1px solid #ffeaea;">
                        <i class="bi bi-box-arrow-right"></i> ออกจากระบบ
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="nav-item login-btn-custom">
                เข้าสู่ระบบ
            </a>
        @endif
    </div>
</nav>
