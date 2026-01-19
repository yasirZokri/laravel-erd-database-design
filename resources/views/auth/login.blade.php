@extends('layouts.auth')

@section('title', 'Admin Login')

@section('content')

    <h4 class="text-center mb-4">Admin Login</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf



        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="admin_email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="admin_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Login
        </button>
@endsection
