@extends('layouts.app')

@section('title', 'Users')
@section('page_title', 'Users / View (static)')

@section('content')
    <div class="grid">
        <div class="card">
            <div class="card-header">
                <div>
                    <div style="font-weight:700;">Users</div>
                    <div class="muted" style="font-size:13px;">Static list (latest 20).</div>
                </div>
                <div style="display:flex; gap:10px;">
                    <a class="btn btn-primary" href="{{ url('/users/create') }}">Create User</a>
                    <a class="btn" href="{{ url('/users/manage') }}">Manage</a>
                </div>
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
                        @forelse($users as $u)
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

