<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Auth')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div style="min-height: 100vh; display:grid; place-items:center; padding: 32px 16px;">
        <div style="width: 100%; max-width: 520px;">
            <div class="card">
                <div class="card-header">
                    <div style="font-weight:700;">@yield('title', 'Auth')</div>
                    <div class="muted" style="font-size:13px;">StarsCompany Admin Panel</div>
                </div>
                <div class="card-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>

</html>
