@extends('layouts.app')

@section('title', 'Admins')
@section('page_title', 'Admins / View (static)')

@section('content')
    <div class="grid">
        <div class="card">
            <div class="card-header">
                <div>
                    <div style="font-weight:700;">Admins</div>
                    <div class="muted" style="font-size:13px;">Static list (latest 20).</div>
                </div>
                <div style="display:flex; gap:10px;">
                    <a class="btn btn-primary" href="{{ url('/admins/create') }}">Create Admin</a>
                    <a class="btn" href="{{ url('/admins/manage') }}">Manage</a>
                </div>
            </div>
            <div class="card-body" style="padding:0;">
                <table>
                    <thead>
                        <tr>
                            <th style="width:90px;">ID</th>
                            <th>Email</th>
                            <th style="width:120px;">Active</th>
                            <th style="width:180px;">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $a)
                            <tr>
                                <td>{{ $a->admin_id }}</td>
                                <td style="font-weight:600;">{{ $a->admin_email }}</td>
                                <td>{{ $a->isActive ? 'Yes' : 'No' }}</td>
                                <td class="muted">{{ optional($a->created_at)->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="muted" style="text-align:center; padding: 18px;">
                                    No admins found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

