<ul class="menu" id="menu-nav">
    <li class="sidebar-item">
        <a href="{{ route('dashboard') }}" class='sidebar-link'>
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
        </a>
    </li>
    
    <li class="sidebar-title">Menu</li>

    <li class="sidebar-item has-sub">
        <a href="#" class='sidebar-link'>
            <i class="bi bi-stack"></i>
            <span>Master Data</span>
        </a>

        <ul class="submenu">
            <li class="submenu-item">
                <a href="{{ route('user.index') }}" class="submenu-link">Kelola User</a>
            </li>
        </ul>

    </li>

</ul>