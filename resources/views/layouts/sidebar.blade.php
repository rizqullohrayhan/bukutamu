<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="/guestbook" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('LogoUNS.png') }}" alt="" height="45">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('SPMB.png') }}" alt="" height="75">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="/guestbook" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('LogoUNS.png') }}" alt="" height="45">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('SPMB.png') }}" alt="" height="75">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav d-flex justify-content-between" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link menu-link fw-medium {{ Request::is('guestbook') ? 'active fw-bold' : '' }}" href="/guestbook"
                       role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-book-2-line"></i> <span >@lang('Riwayat Tamu')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link fw-medium {{ Request::is('guests') ? 'active fw-bold' : '' }}" href="/guests"
                       role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-team-line"></i> <span >@lang('Data Tamu')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link fw-medium {{ Request::is('problems') ? 'active fw-bold' : '' }}" href="/problems"
                       role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-team-line"></i> <span >@lang('Kategori Keperluan')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link fw-medium {{ Request::is('analytics') ? 'active fw-bold' : '' }}" href="/analytics"
                       role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-line-chart-line"></i> <span >@lang('Analitik Data')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link fw-medium {{ Request::is('surat') ? 'active fw-bold' : '' }}" href="/surat"
                        role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-book-line"></i> <span >@lang('Ekspedisi Surat Masuk')</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
