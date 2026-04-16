@extends('layouts.app')

@section('title', 'Attendance')
@section('page_title', 'Attendance')

@section('content')
    <form action="{{ route('post.attendance') }}" method="POST">
        @csrf

        <div class="card">
            <div class="card-header">
                <div>
                    <div style="font-weight:700;">Attendance Sheet</div>
                    <div class="muted" style="font-size:13px;">Save attendance for each user.</div>
                </div>
                <button type="submit" class="btn btn-primary">Save Attendance</button>
            </div>

            <div class="card-body" style="padding:0;">
                <table>
                    <thead>
                        <tr>
                            <th style="width:240px;">User</th>
                            <th style="width:220px;">Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td style="font-weight:600;">{{ $user->name }}</td>
                                <td>
                                    <select name="attendance[{{ $user->id }}]">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->type }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <textarea name="details[{{ $user->id }}]" rows="2" placeholder="Optional notes..."></textarea>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
@endsection
