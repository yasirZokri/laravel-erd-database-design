<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>
    <style>
        :root{
            --bg: #f6f8fc;
            --panel: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e5e7eb;
            --primary: #2563eb;
            --primary-2: #1d4ed8;
            --danger: #dc2626;
            --success: #16a34a;
            --shadow: 0 14px 34px rgba(15, 23, 42, .10);
            --radius: 14px;
        }

        *{ box-sizing: border-box; }
        body{
            margin:0;
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji","Segoe UI Emoji";
            background:
                radial-gradient(900px 450px at 15% 0%, rgba(37, 99, 235, .10), transparent 60%),
                radial-gradient(900px 450px at 85% 0%, rgba(16, 185, 129, .08), transparent 60%),
                var(--bg);
            color: var(--text);
        }

        .layout{
            display:flex;
            min-height:100vh;
            width:100%;
        }

        .sidebar{
            width: 280px;
            border-right: 1px solid var(--border);
            background: rgba(255,255,255,.72);
            backdrop-filter: blur(10px);
            padding: 18px 14px;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .brand{
            display:flex;
            align-items:center;
            gap:10px;
            padding: 10px 10px 14px;
            margin-bottom: 8px;
        }
        .brand .dot{
            width: 12px;
            height: 12px;
            border-radius: 99px;
            background: linear-gradient(135deg, var(--primary), #22c55e);
            box-shadow: 0 10px 22px rgba(37, 99, 235, .20);
        }
        .brand .name{
            font-weight: 700;
            letter-spacing: .2px;
        }
        .brand .sub{
            margin-left:auto;
            font-size: 12px;
            color: var(--muted);
        }

        .nav{
            list-style:none;
            padding:0;
            margin: 8px 0 0;
        }

        .nav > li{
            margin: 6px 0;
        }

        .nav button, .nav a{
            width:100%;
            border:0;
            background: transparent;
            padding: 10px 10px;
            border-radius: 12px;
            text-align:left;
            cursor:pointer;
            color: var(--text);
            font-size: 14px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            transition: background-color 160ms ease, transform 120ms ease;
            text-decoration:none;
        }

        .nav button:hover, .nav a:hover{
            background: rgba(37, 99, 235, .08);
            transform: translateY(-1px);
        }

        .nav .chev{
            color: var(--muted);
            font-size: 12px;
        }

        .submenu{
            list-style:none;
            padding: 6px 0 2px 10px;
            margin: 0;
            border-left: 2px solid rgba(37, 99, 235, .18);
            margin-left: 10px;
            display:none;
        }
        .submenu.open{ display:block; }
        .submenu a{
            padding: 9px 10px;
            font-size: 13px;
            color: #0f172a;
        }
        .submenu a .hint{
            color: var(--muted);
            font-size: 12px;
            margin-left: 8px;
        }

        .content{
            flex:1;
            padding: 24px 22px;
        }

        .topbar{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .page-title{
            margin:0;
            font-size: 18px;
            letter-spacing: .2px;
        }

        .card{
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .card-header{
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap: 10px;
        }

        .card-body{ padding: 16px; }

        .grid{
            display:grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }

        table{
            width:100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        th, td{
            padding: 12px 12px;
            border-bottom: 1px solid var(--border);
            text-align:left;
            font-size: 14px;
        }
        th{
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            background: rgba(15,23,42,.02);
        }
        tr:last-child td{ border-bottom: 0; }

        .row-actions{
            display:flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .btn{
            border: 1px solid var(--border);
            background: #fff;
            color: var(--text);
            padding: 9px 12px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 13px;
            transition: transform 120ms ease, background-color 160ms ease, border-color 160ms ease;
            text-decoration:none;
            display:inline-flex;
            align-items:center;
            gap: 8px;
        }
        .btn:hover{ transform: translateY(-1px); background: rgba(15,23,42,.02); }
        .btn-primary{
            background: var(--primary);
            border-color: transparent;
            color:#fff;
            box-shadow: 0 10px 18px rgba(37,99,235,.18);
        }
        .btn-primary:hover{ background: var(--primary-2); }
        .btn-danger{ border-color: rgba(220, 38, 38, .35); color: var(--danger); }

        .flash{
            padding: 10px 12px;
            border-radius: 12px;
            font-size: 13px;
            border: 1px solid var(--border);
            background: rgba(255,255,255,.75);
            margin-bottom: 12px;
        }
        .flash.success{ border-color: rgba(22,163,74,.35); background: rgba(22,163,74,.10); color: #14532d; }
        .flash.error{ border-color: rgba(220,38,38,.35); background: rgba(220,38,38,.08); color: #7f1d1d; }

        .form{
            max-width: 560px;
            margin: 0 auto;
        }
        .field{ margin-bottom: 14px; }
        label{
            display:block;
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 6px;
        }
        input[type="text"], input[type="email"], input[type="password"], select{
            width:100%;
            padding: 12px 12px;
            border: 1px solid var(--border);
            border-radius: 12px;
            outline: none;
            font-size: 14px;
            transition: border-color 160ms ease, box-shadow 160ms ease;
            background: #fff;
        }
        input:focus, select:focus{
            border-color: rgba(37, 99, 235, 0.55);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }
        .error-text{
            margin-top: 6px;
            font-size: 12px;
            color: var(--danger);
        }

        .muted{ color: var(--muted); }

        @media (max-width: 920px){
            .sidebar{ position: fixed; left:0; top:0; transform: translateX(-105%); transition: transform 180ms ease; z-index: 50; }
            .sidebar.open{ transform: translateX(0); }
            .content{ padding: 18px 14px; }
            .topbar{ position: sticky; top: 0; background: rgba(246,248,252,.88); backdrop-filter: blur(10px); padding: 10px 0; z-index: 5; }
        }
    </style>
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
