@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

    <div class="container-fluid mt-4">

        {{-- ====== KPI CARDS ====== --}}
        <div class="row g-4 mb-4">

            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small class="text-muted">Total Users</small>
                        <h2 class="fw-bold mt-2">1,248</h2>
                        <span class="text-success">▲ 12% this month</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small class="text-muted">Active Users</small>
                        <h2 class="fw-bold mt-2">932</h2>
                        <span class="text-primary">Online</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small class="text-muted">Admins</small>
                        <h2 class="fw-bold mt-2">6</h2>
                        <span class="text-warning">Protected</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small class="text-muted">Attendance Today</small>
                        <h2 class="fw-bold mt-2">89%</h2>
                        <span class="text-danger">▼ 3%</span>
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

                        <div class="row text-center">
                            <div class="col">
                                <h4 class="fw-bold">72%</h4>
                                <small class="text-muted">Daily Activity</small>
                            </div>
                            <div class="col">
                                <h4 class="fw-bold">18</h4>
                                <small class="text-muted">New Users</small>
                            </div>
                            <div class="col">
                                <h4 class="fw-bold">4</h4>
                                <small class="text-muted">Reports</small>
                            </div>
                        </div>

                        <hr>

                        <p class="text-muted mb-0">
                            The system is running normally.
                            No critical issues detected today 🌿
                        </p>

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
                                Attendance
                                <span class="badge bg-warning text-dark">Partial</span>
                            </li>
                        </ul>

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
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>john@example.com</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane Smith</td>
                                    <td>jane@example.com</td>
                                    <td><span class="badge bg-secondary">Offline</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
