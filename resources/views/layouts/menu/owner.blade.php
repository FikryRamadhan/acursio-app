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

    <li class="sidebar-item has-sub">
        <a href="#" class='sidebar-link'>
            <i class="bi bi-person-lines-fill"></i>
            <span>Absensi Kerja</span>
        </a>

        <ul class="submenu">
            <li class="submenu-item">
                <a href="{{ route('user.index') }}" class="submenu-link">Kelola User</a>
            </li>
        </ul>
    </li>

    <li class="sidebar-item has-sub">
        <a href="#" class='sidebar-link'>
            <i class="bi bi-database-fill"></i>
            <span>Rekapan Order</span>
        </a>

        <ul class="submenu">
            <li class="submenu-item">
                <a href="{{ route('user.index') }}" class="submenu-link">Kelola User</a>
            </li>
        </ul>
    </li>

    <li class="sidebar-title">Configuration</li>

    <li class="sidebar-item has-sub">
        <a href="#" class='sidebar-link'>
            <i class="bi bi-gear"></i>
            <span>Setting</span>
        </a>

        <ul class="submenu">
            <li class="submenu-item">
                <a href="{{ route('settings.set-profile') }}" class="submenu-link">Profile</a>
            </li>
            <li class="submenu-item">
                <a href="{{ route('settings.set-password') }}" class="submenu-link">Ganti Password</a>
            </li>
        </ul>
    </li>
    <li class="sidebar-item">
        <a href="{{ route('logout') }}" class='sidebar-link'>
            <i class="bi bi-power"></i>
            <span>Log Out</span>
        </a>
    </li>
</ul>