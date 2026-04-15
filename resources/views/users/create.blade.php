@extends('layouts.app')

@section('title', 'Create User')
@section('page_title', 'Users / Create')

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <div style="font-weight:700;">Create User</div>
                <div class="muted" style="font-size:13px;">Add a new user to the system.</div>
            </div>
            <a class="btn" href="{{ url('/users') }}">Back</a>
        </div>
        <div class="card-body">
            <form class="form" method="POST" action="{{ route('users.store') }}">
                @csrf

                <div class="field">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required>
                    @error('name')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>
                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required>
                    @error('password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display:flex; justify-content:flex-end; gap:10px; margin-top: 14px;">
                    <button class="btn btn-primary" type="submit">Create User</button>
                </div>

                <div class="muted" style="font-size:12px; margin-top: 10px;">Password must be at least 8 characters.</div>
            </form>
        </div>
    </div>
@endsection
