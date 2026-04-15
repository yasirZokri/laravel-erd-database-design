@extends('layouts.app')

@section('title', 'dashboard')

@section('content')
<style>
   .dashboard-grid {
  display: grid;
  grid-template-columns: repeat(12, 1fr);
  gap: 20px;
  padding: 20px;
}

.box {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

/* Small cards */
.box-1 { grid-column: span 3; }
.box-2 { grid-column: span 3; }
.box-3 { grid-column: span 3; }
.box-4 { grid-column: span 3; }

/* Charts */
.chart-large {
  grid-column: span 8;
  height: 300px;
}

.chart-small {
  grid-column: span 4;
  height: 300px;
}

/* Status */
.status-box {
  grid-column: span 4;
  height: 300px;
}

/* Table */
.table-box {
  grid-column: span 8;
}

/* Responsive */
@media (max-width: 992px) {
  .box-1, .box-2, .box-3, .box-4 {
    grid-column: span 6;
  }

  .chart-large,
  .chart-small,
  .status-box,
  .table-box {
    grid-column: span 12;
  }
}
</style>
    <div class="container-fluid mt-4">

        {{-- ====== KPI CARDS ====== --}}
        <div class="row g-4 mb-4">

            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small class="text-muted">Total Users</small>
                        <h2 class="fw-bold mt-2">{{ number_format($totalUsers ?? 0) }}</h2>
                        <span class="text-muted">{{ number_format($newUsersThisMonth ?? 0) }} new this month</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small class="text-muted">Attendance Today</small>
                        <h2 class="fw-bold mt-2">{{ (int) ($attendanceRateToday ?? 0) }}%</h2>
                        <span class="text-muted">{{ number_format($attendanceUsersToday ?? 0) }} users marked</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small class="text-muted">Admins</small>
                        <h2 class="fw-bold mt-2">{{ number_format($totalAdmins ?? 0) }}</h2>
                        <span class="text-muted">{{ number_format($activeAdmins ?? 0) }} active</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small class="text-muted">System</small>
                        <h2 class="fw-bold mt-2">OK</h2>
                        <span class="text-muted">Last updated: <span id="dash-last-updated">—</span></span>
                    </div>
                </div>
            </div>

        </div>

        {{-- ====== ANALYTICS SECTION ====== --}}
        <div class="row g-4 mb-4">

            {{-- System Overview --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-bold">
                        System Overview
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="fw-semibold">User registrations (last 30 days)</div>
                                    <div class="text-muted small" id="reg-loading">Loading…</div>
                                </div>
                                <div style="height: 260px;">
                                    <canvas id="chart-registrations"></canvas>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="my-3">
                            </div>

                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="fw-semibold">Attendance coverage (last 14 days)</div>
                                    <div class="text-muted small" id="att-loading">Loading…</div>
                                </div>
                                <div style="height: 260px;">
                                    <canvas id="chart-attendance"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-bold">
                        System Status
                    </div>
                    <div class="card-body">

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                Database
                                <span class="badge bg-success">Online</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                Auth System
                                <span class="badge bg-success">Running</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                Attendance Today
                                <span class="badge bg-primary">{{ (int) ($attendanceRateToday ?? 0) }}%</span>
                            </li>
                        </ul>

                        <hr>

                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-semibold">Today status breakdown</div>
                            <div class="text-muted small" id="status-loading">Loading…</div>
                        </div>
                        <div style="height: 240px;">
                            <canvas id="chart-status-today"></canvas>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        {{-- ====== RECENT USERS TABLE ====== --}}
        <div class="row g-4">

            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold">
                        Recent Users
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(($recentUsers ?? []) as $u)
                                    <tr>
                                        <td>{{ $u->id }}</td>
                                        <td class="fw-semibold">{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td class="text-muted">{{ optional($u->created_at)->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
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
