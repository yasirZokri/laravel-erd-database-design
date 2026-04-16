@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
    <div class="grid">
        <div class="kpi-grid">
            <div class="card">
                <div class="card-body">
                    <div class="kpi-label">Total Users</div>
                    <div class="kpi-value">{{ number_format($totalUsers ?? 0) }}</div>
                    <div class="kpi-sub">{{ number_format($newUsersThisMonth ?? 0) }} new this month</div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="kpi-label">Attendance Today</div>
                    <div class="kpi-value">{{ (int) ($attendanceRateToday ?? 0) }}%</div>
                    <div class="kpi-sub">{{ number_format($attendanceUsersToday ?? 0) }} users marked</div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="kpi-label">Admins</div>
                    <div class="kpi-value">{{ number_format($totalAdmins ?? 0) }}</div>
                    <div class="kpi-sub">{{ number_format($activeAdmins ?? 0) }} active</div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="kpi-label">System</div>
                    <div class="kpi-value">OK</div>
                    <div class="kpi-sub">Last updated: <span id="dash-last-updated">—</span></div>
                </div>
            </div>
        </div>

        <div class="dash-grid">
            <div class="card">
                <div class="card-header">
                    <div style="font-weight:700;">System Overview</div>
                    <div class="muted" style="font-size:13px;">Live charts</div>
                </div>
                <div class="card-body">
                    <div style="display:flex; align-items:center; justify-content:space-between; gap: 10px; margin-bottom: 8px;">
                        <div style="font-weight:600;">User registrations (last 30 days)</div>
                        <div class="muted" style="font-size:12px;" id="reg-loading">Loading…</div>
                    </div>
                    <div style="height: 260px;">
                        <canvas id="chart-registrations"></canvas>
                    </div>

                    <div style="height: 1px; background: var(--border); margin: 14px 0;"></div>

                    <div style="display:flex; align-items:center; justify-content:space-between; gap: 10px; margin-bottom: 8px;">
                        <div style="font-weight:600;">Attendance coverage (last 14 days)</div>
                        <div class="muted" style="font-size:12px;" id="att-loading">Loading…</div>
                    </div>
                    <div style="height: 260px;">
                        <canvas id="chart-attendance"></canvas>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div style="font-weight:700;">System Status</div>
                </div>
                <div class="card-body">
                    <ul class="list">
                        <li>
                            <span>Database</span>
                            <span class="badge success">Online</span>
                        </li>
                        <li>
                            <span>Auth System</span>
                            <span class="badge success">Running</span>
                        </li>
                        <li>
                            <span>Attendance Today</span>
                            <span class="badge primary">{{ (int) ($attendanceRateToday ?? 0) }}%</span>
                        </li>
                    </ul>

                    <div style="height: 1px; background: var(--border); margin: 14px 0;"></div>

                    <div style="display:flex; align-items:center; justify-content:space-between; gap: 10px; margin-bottom: 8px;">
                        <div style="font-weight:600;">Today status breakdown</div>
                        <div class="muted" style="font-size:12px;" id="status-loading">Loading…</div>
                    </div>
                    <div style="height: 240px;">
                        <canvas id="chart-status-today"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div style="font-weight:700;">Recent Users</div>
                <a class="btn" href="{{ route('users.manage') }}">Manage Users</a>
            </div>
            <div class="card-body" style="padding:0;">
                <table>
                    <thead>
                        <tr>
                            <th style="width:90px;">ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th style="width:180px;">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($recentUsers ?? []) as $u)
                            <tr>
                                <td>{{ $u->id }}</td>
                                <td style="font-weight:600;">{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td class="muted">{{ optional($u->created_at)->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="muted" style="text-align:center; padding: 18px;">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        (function () {
            const fmtDate = (d) => {
                try { return new Date(d).toLocaleString(); } catch { return d; }
            };

            const colors = {
                blue: 'rgba(13, 110, 253, 0.9)',
                blueFill: 'rgba(13, 110, 253, 0.15)',
                green: 'rgba(25, 135, 84, 0.9)',
                greenFill: 'rgba(25, 135, 84, 0.15)',
                gray: 'rgba(108, 117, 125, 0.9)',
            };

            let regChart, attChart, statusChart;

            async function fetchJson(url) {
                const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                if (!res.ok) throw new Error('Failed to load: ' + url);
                return await res.json();
            }

            function ensureChart(ctx, type, data, options, existing) {
                if (existing) {
                    existing.data = data;
                    existing.options = options;
                    existing.update();
                    return existing;
                }
                return new Chart(ctx, { type, data, options });
            }

            async function loadCharts() {
                const updatedEl = document.getElementById('dash-last-updated');
                const regLoading = document.getElementById('reg-loading');
                const attLoading = document.getElementById('att-loading');
                const statusLoading = document.getElementById('status-loading');

                try {
                    regLoading.textContent = 'Loading…';
                    const reg = await fetchJson(@json(route('dashboard.charts.registrations')));
                    regLoading.textContent = '';
                    const regCtx = document.getElementById('chart-registrations');
                    regChart = ensureChart(regCtx, 'line', {
                        labels: reg.labels,
                        datasets: [{
                            label: 'Users',
                            data: reg.values,
                            borderColor: colors.blue,
                            backgroundColor: colors.blueFill,
                            fill: true,
                            tension: 0.25,
                            pointRadius: 2,
                        }]
                    }, {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { ticks: { maxTicksLimit: 6 } },
                            y: { beginAtZero: true, ticks: { precision: 0 } }
                        }
                    }, regChart);
                } catch (e) {
                    regLoading.textContent = 'Failed';
                }

                try {
                    attLoading.textContent = 'Loading…';
                    const att = await fetchJson(@json(route('dashboard.charts.attendance')));
                    attLoading.textContent = '';
                    const attCtx = document.getElementById('chart-attendance');
                    attChart = ensureChart(attCtx, 'bar', {
                        labels: att.labels,
                        datasets: [{
                            label: 'Users marked',
                            data: att.values,
                            backgroundColor: colors.greenFill,
                            borderColor: colors.green,
                            borderWidth: 1,
                        }]
                    }, {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { ticks: { maxTicksLimit: 7 } },
                            y: { beginAtZero: true, ticks: { precision: 0 } }
                        }
                    }, attChart);
                } catch (e) {
                    attLoading.textContent = 'Failed';
                }

                try {
                    statusLoading.textContent = 'Loading…';
                    const st = await fetchJson(@json(route('dashboard.charts.attendance_status_today')));
                    statusLoading.textContent = '';
                    const stCtx = document.getElementById('chart-status-today');
                    statusChart = ensureChart(stCtx, 'doughnut', {
                        labels: st.labels,
                        datasets: [{
                            data: st.values,
                            backgroundColor: [
                                'rgba(13, 110, 253, 0.85)',
                                'rgba(25, 135, 84, 0.85)',
                                'rgba(255, 193, 7, 0.85)',
                                'rgba(220, 53, 69, 0.85)',
                                'rgba(108, 117, 125, 0.85)',
                            ],
                            borderWidth: 0,
                        }]
                    }, {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom' } }
                    }, statusChart);
                } catch (e) {
                    statusLoading.textContent = 'Failed';
                }

                if (updatedEl) updatedEl.textContent = fmtDate(new Date());
            }

            loadCharts();
            setInterval(loadCharts, 60_000);
        })();
    </script>
@endsection
