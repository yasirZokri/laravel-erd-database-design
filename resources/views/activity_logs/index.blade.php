@extends('layouts.app')

@section('title', 'Activity Logs')
@section('page_title', 'Activity Logs')

@section('content')
    <div class="grid">
        <div class="card">
            <div class="card-header">
                <div>
                    <div style="font-weight:700;">Activity Logs</div>
                    <div class="muted" style="font-size:13px;">Latest 200 actions.</div>
                </div>
            </div>

            <div class="card-body" style="padding:0;">
                <table>
                    <thead>
                        <tr>
                            <th style="width:180px;">Time</th>
                            <th style="width:140px;">Actor</th>
                            <th style="width:160px;">Action</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td class="muted">{{ optional($log->created_at)->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    @if($log->admin)
                                        <span style="font-weight:600;">Admin</span>
                                        <div class="muted" style="font-size:12px;">{{ $log->admin->admin_email }}</div>
                                    @elseif($log->user)
                                        <span style="font-weight:600;">User</span>
                                        <div class="muted" style="font-size:12px;">{{ $log->user->email }}</div>
                                    @else
                                        <span class="muted">System</span>
                                    @endif
                                </td>
                                <td style="font-weight:600;">{{ $log->action }}</td>
                                <td class="muted">{{ $log->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="muted" style="text-align:center; padding: 18px;">
                                    No logs yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

