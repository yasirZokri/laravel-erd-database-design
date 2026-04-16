<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
</head>
<body>
    <div class="layout">
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <div class="dot"></div>
                <div class="name">StarsCompany</div>
                <div class="sub">Admin</div>
            </div>

            <ul class="nav">
                <li>
                    <button type="button" class="menu-toggle" data-menu="users">
                        <span>Users</span>
                        <span class="chev">▾</span>
                    </button>
                    <ul class="submenu" id="menu-users">
                        <li><a href="{{ url('/users') }}">View Users <span class="hint">(static)</span></a></li>
                        <li><a href="{{ url('/users/create') }}">Create User</a></li>
                        <li><a href="{{ url('/users/manage') }}">Delete / Update User</a></li>
                    </ul>
                </li>

                <li>
                    <button type="button" class="menu-toggle" data-menu="admins">
                        <span>Admins</span>
                        <span class="chev">▾</span>
                    </button>
                    <ul class="submenu" id="menu-admins">
                        <li><a href="{{ url('/admins') }}">View Admins <span class="hint">(static)</span></a></li>
                        <li><a href="{{ url('/admins/create') }}">Create Admin</a></li>
                        <li><a href="{{ url('/admins/manage') }}">Delete / Update Admin</a></li>
                    </ul>
                </li>

                <li style="margin-top: 10px;">
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                </li>
                
                <li style="margin-top: 10px;">
                    <a href="{{ url('/attendance') }}">attendance</a>
                </li>

                <li style="margin-top: 10px;">
                    <a href="{{ url('/activity-logs') }}">Activity Logs</a>
                </li>

                <li style="margin-top: 10px;">
                    <a href="{{ url('/reports') }}">Reports</a>
                </li>
            </ul>

            <div style="margin-top: 14px; padding: 0 10px;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn" type="submit" style="width:100%; justify-content:center; border-radius: 12px;">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="content">
            <div class="topbar">
                <h1 class="page-title">@yield('page_title', 'Home')</h1>
                <button class="btn" type="button" id="sidebarBtn" style="display:none;">Menu</button>
            </div>

            @if (session('success'))
                <div class="flash success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="flash error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        (function () {
            const sidebar = document.getElementById('sidebar');
            const sidebarBtn = document.getElementById('sidebarBtn');
            const isMobile = () => window.matchMedia('(max-width: 920px)').matches;

            function setSidebarBtnVisibility() {
                sidebarBtn.style.display = isMobile() ? 'inline-flex' : 'none';
                if (!isMobile()) sidebar.classList.remove('open');
            }

            function openMenu(menuKey) {
                const el = document.getElementById('menu-' + menuKey);
                if (!el) return;
                el.classList.add('open');
                localStorage.setItem('sidebar.menu.' + menuKey, 'open');
            }

            function toggleMenu(menuKey) {
                const el = document.getElementById('menu-' + menuKey);
                if (!el) return;
                const isOpen = el.classList.toggle('open');
                localStorage.setItem('sidebar.menu.' + menuKey, isOpen ? 'open' : 'closed');
            }

            document.querySelectorAll('.menu-toggle').forEach(btn => {
                btn.addEventListener('click', () => toggleMenu(btn.dataset.menu));
            });

            ['users','admins'].forEach(k => {
                if (localStorage.getItem('sidebar.menu.' + k) === 'open') openMenu(k);
            });

            sidebarBtn.addEventListener('click', () => sidebar.classList.toggle('open'));
            window.addEventListener('resize', setSidebarBtnVisibility);
            setSidebarBtnVisibility();
        })();
    </script>
    @yield('scripts')
</body>
</html>
