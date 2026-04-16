@extends('layouts.auth')

@section('title', 'Admin Login')

@section('content')

    @if ($errors->any())
        <div class="flash error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}" class="form">
        @csrf

        <div class="field">
            <label for="admin_email">Email</label>
            <input id="admin_email" type="email" name="admin_email" required autofocus>
        </div>

        <div class="field">
            <label for="admin_password">Password</label>
            <input id="admin_password" type="password" name="admin_password" required>
        </div>

        <div style="display:flex; justify-content:flex-end; margin-top: 14px;">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
@endsection
