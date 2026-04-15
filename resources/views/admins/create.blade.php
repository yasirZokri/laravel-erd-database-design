@extends('layouts.app')

@section('title', 'Create Admin')
@section('page_title', 'Admins / Create')

@section('styles')
    <style>
        .checkbox-row{
            display:flex;
            align-items:center;
            gap: 10px;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fff;
        }
        .checkbox-row input{ width: 18px; height: 18px; }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <div style="font-weight:700;">Create Admin</div>
                <div class="muted" style="font-size:13px;">Add a new admin account.</div>
            </div>
            <a class="btn" href="{{ url('/admins') }}">Back</a>
        </div>
        <div class="card-body">
            <form class="form" method="POST" action="{{ route('admins.store') }}">
                @csrf

                <div class="field">
                    <label for="admin_email">Email</label>
                    <input id="admin_email" name="admin_email" type="email" value="{{ old('admin_email') }}" autocomplete="email" required>
                    @error('admin_email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="admin_password">Password</label>
                    <input id="admin_password" name="admin_password" type="password" autocomplete="new-password" required>
                    @error('admin_password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label>Active</label>
                    <div class="checkbox-row">
                        <input id="isActive" name="isActive" type="checkbox" value="1" {{ old('isActive') ? 'checked' : '' }}>
                        <label for="isActive" style="margin:0; color: var(--text);">Enable this admin account</label>
                    </div>
                    @error('isActive')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display:flex; justify-content:flex-end; gap:10px; margin-top: 14px;">
                    <button class="btn btn-primary" type="submit">Create Admin</button>
                </div>
            </form>
        </div>
    </div>
@endsection

