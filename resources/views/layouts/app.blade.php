<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Wealthora') — {{ config('app.name') }}</title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="{{ url('public/frontend/images/favicon.png?v=0.1') }}" type="image/x-icon">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- ApexCharts -->
    <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.49.0/dist/apexcharts.css" rel="stylesheet">
    <!-- Leaflet -->
    <link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" rel="stylesheet">

    <!-- 1. Load jQuery library first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #3b82f6;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #f8fafc;
            --topbar-height: 64px;
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --body-bg: #f1f5f9;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--body-bg);
            margin: 0;
            overflow-x: hidden;
        }

        /* ── Sidebar ── */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 1040;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            border-bottom: 1px solid #1e293b;
            text-decoration: none;
        }

        .sidebar-brand .brand-icon {
            width: 36px; height: 36px;
            background: var(--primary);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-text {
            margin-left: .75rem;
            font-size: 1.05rem;
            font-weight: 700;
            color: #f8fafc;
            letter-spacing: -.3px;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0;
            scrollbar-width: thin;
            scrollbar-color: #1e293b transparent;
        }

        .nav-section-label {
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #475569;
            padding: .75rem 1.5rem .25rem;
        }

        .sidebar-nav .nav-item > .nav-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .6rem 1.5rem;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            border-radius: 0;
            transition: all .2s;
            position: relative;
        }

        .sidebar-nav .nav-item > .nav-link:hover {
            background: var(--sidebar-hover);
            color: #f8fafc;
        }

        .sidebar-nav .nav-item > .nav-link.active {
            background: rgba(59,130,246,.15);
            color: #60a5fa;
        }

        .sidebar-nav .nav-item > .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: var(--primary);
            border-radius: 0 2px 2px 0;
        }

        .sidebar-nav .nav-item > .nav-link i {
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        /* Submenu */
        .sidebar-nav .collapse .nav-link {
            padding-left: 3.25rem;
            font-size: .825rem;
            color: #64748b;
        }

        .sidebar-nav .collapse .nav-link:hover,
        .sidebar-nav .collapse .nav-link.active {
            color: #93c5fd;
            background: transparent;
        }

        .sidebar-nav .collapse .nav-link.active {
            color: #60a5fa;
        }

        .chevron {
            margin-left: auto;
            transition: transform .25s;
            font-size: .7rem;
        }

        [aria-expanded="true"] .chevron { transform: rotate(90deg); }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #1e293b;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .user-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: .85rem;
            flex-shrink: 0;
        }

        .user-info .user-name {
            font-size: .8rem;
            font-weight: 600;
            color: #f1f5f9;
            line-height: 1.2;
        }

        .user-info .user-role {
            font-size: .7rem;
            color: #64748b;
        }

        /* ── Topbar ── */
        #topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            z-index: 1030;
            gap: 1rem;
        }

        #topbar .page-title {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            flex: 1;
        }

        .btn-sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #64748b;
            cursor: pointer;
            padding: .25rem .5rem;
        }

        /* ── Main Content ── */
        #main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 1.75rem;
            min-height: calc(100vh - var(--topbar-height));
        }

        /* ── Cards ── */
        .card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,.04);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.25rem;
        }

        /* ── Stat Cards ── */
        .stat-card {
            border-radius: 14px;
            padding: 1.25rem 1.5rem;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .stat-card .stat-icon {
            width: 48px; height: 48px;
            background: rgba(255,255,255,.2);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            line-height: 1;
            margin: .75rem 0 .25rem;
        }

        .stat-card .stat-label {
            font-size: .8rem;
            opacity: .85;
            font-weight: 500;
        }

        /* ── Tables ── */
        .table thead th {
            background: #f8fafc;
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
            font-size: .875rem;
            color: #334155;
        }

        .badge { font-weight: 600; font-size: .7rem; }

        /* ── Buttons ── */
        .btn {
            font-size: .825rem;
            font-weight: 600;
            border-radius: 8px;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* ── Forms ── */
        .form-control, .form-select {
            border-radius: 8px;
            border: 1.5px solid #e2e8f0;
            font-size: .875rem;
            padding: .5rem .875rem;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59,130,246,.1);
        }

        .form-label {
            font-size: .8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: .35rem;
        }

        /* ── Alerts ── */
        .alert { border-radius: 10px; font-size: .875rem; }

        /* ── Overlay ── */
        #sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.5);
            z-index: 1039;
        }

        /* ── Responsive ── */
        @media (max-width: 991px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #sidebar-overlay.show { display: block; }
            #topbar { left: 0; }
            #main-content { margin-left: 0; }
            .btn-sidebar-toggle { display: block; }
        }

        @media (max-width: 576px) {
            #main-content { padding: 1rem; }
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- Sidebar Overlay -->
<div id="sidebar-overlay"></div>

@php
    $authUser = auth()->user();
@endphp

<!-- ─── Sidebar ─────────────────────────────────────────────── -->
<nav id="sidebar">
    <a href="{{ route('web.dashboard.index') }}" class="sidebar-brand">

        <div class="brand-text"><img src="{{ url('public/frontend/images/footer-logo.png') }}" alt="TrackingApp Logo" style="height: 40px;"></div>
    </a>

    <div class="sidebar-nav">
        @php
            $sidebarMenus = \App\Models\Menu::whereNull('parent_id')->with('children')->where('is_active',true)->orderBy('sort_order')->get();
        @endphp
        <span class="nav-section-label">Navigation</span>
        <ul class="nav flex-column">
            <script>
                var count = 0;
            </script>
            @foreach($sidebarMenus as $menu)
                @if($menu->children->isNotEmpty())
                    <script>
                        count = 0;
                    </script>
                    <li class="nav-item" id="parent_menu_{{$menu->id}}">
                        <a href="#sm-{{ $menu->id }}" class="nav-link" data-bs-toggle="collapse" aria-expanded="false">
                            <i class="{{ $menu->icon ?? 'bi bi-circle' }}"></i> {{ $menu->name }}
                            <i class="bi bi-chevron-right chevron"></i>
                        </a>
                        <div class="collapse" id="sm-{{ $menu->id }}">
                            <ul class="nav flex-column">
                                @foreach($menu->children as $child)
                                    @if($authUser->hasPermission($child->slug,'can_view'))
                                        <li class="nav-item">
                                            <a href="{{ $child->route ? route( 'web.'.$child->route ) : 'javascript:void(0)' }}"
                                                class="nav-link {{$child->route}} {{ $child->route && request()->routeIs( 'web.'.$child->route.'*' ) ? 'active' : '' }}">
                                                <i class="{{ $child->icon ?? 'bi bi-dot' }}"></i> {{ $child->name }}
                                            </a>
                                        </li>
                                        <script>
                                            count++;
                                        </script>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <script>
                            if( count == 0 ){
                                console.log( "#parent_menu_{{$menu->id}}" );
                                $("#parent_menu_{{$menu->id}}").addClass('d-none');
                            }
                        </script>
                    </li>
                @elseif($authUser->hasPermission($menu->slug,'can_view'))
                    <li class="nav-item">
                        <a href="{{ $menu->route ? route( 'web.'.$menu->route) : 'javascript:void(0)' }}"
                            class="nav-link {{ $menu->route && request()->routeIs( 'web.'.$menu->route.'*') ? 'active' : '' }}">
                            <i class="{{ $menu->icon ?? 'bi bi-circle' }}"></i> {{ $menu->name }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>

        <ul class="nav flex-column mt-1">
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" id="logoutForm">@csrf
                    <a href="#" class="nav-link text-danger" onclick="event.preventDefault();document.getElementById('logoutForm').submit();">
                        <i class="bi bi-box-arrow-left"></i> Logout
                    </a>
                </form>
            </li>
        </ul>
    </div>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->full_name ?? 'A', 0, 2)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->full_name ?? 'Admin' }}</div>
                <div class="user-role">{{ auth()->user()->role->name ?? 'Admin' }}</div>
            </div>
        </div>
    </div>
</nav>

<!-- ─── Topbar ──────────────────────────────────────────────── -->
<header id="topbar">
    <button class="btn-sidebar-toggle" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>
    <span class="page-title">@yield('page-title', 'Dashboard')</span>
    <div class="d-flex align-items-center gap-2">
        <small class="text-muted d-none d-md-block">{{ now()->format('D, d M Y') }}</small>
    </div>
</header>

<!-- ─── Main Content ────────────────────────────────────────── -->
<main id="main-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.0/dist/apexcharts.min.js"></script>
<!-- Leaflet -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Sidebar toggle (mobile)
    const sidebarToggle  = document.getElementById('sidebarToggle');
    const sidebar        = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('show');
        sidebarOverlay.classList.toggle('show');
    });

    sidebarOverlay.addEventListener('click', () => {
        sidebar.classList.remove('show');
        sidebarOverlay.classList.remove('show');
    });
</script>

@stack('scripts')
</body>
</html>
