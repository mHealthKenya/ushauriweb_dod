<!-- header start -->
<header class=" main-header bg-white d-flex justify-content-between p-2">
    <div class="header-toggle">
        <div class="menu-toggle mobile-menu-icon">
            <div></div>
            <div></div>
            <div>
            </div>
        </div>

    </div>
    <div class="header-part-right">
        <!-- Full screen toggle -->
        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen=""></i>
        <!-- Grid menu Dropdown -->
        <div class="dropdown dropleft">
            <i class="i-Safe-Box text-muted header-icon" role="button" id="dropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false"></i>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <div class="menu-icon-grid">
                    <a href="#"><i class="i-Shop-4"></i> Profile</a>
                    <a href="#"><i class="i-Library"></i> Documentation</a>
                    <a href="#"><i class="i-Drop"></i> Wiki</a>
                    <a href="#"><i class="i-File-Clipboard-File--Text"></i> Apis</a>
                    <a class="dropdown-item" href="{{route('logout')}}"><i class="nav-icon i-Power-3"></i>Logout</a>
                  
                </div>
            </div>
        </div>
</header>
<!-- header close -->