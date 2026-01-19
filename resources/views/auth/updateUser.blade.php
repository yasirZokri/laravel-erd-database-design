@extends('layouts.dashboard')

@section('title', 'dashboard')

@section('content')

    <div class="container mt-4">

        <div class="card shadow-sm">
            <div class="card-header">
                ✏️ Edit Profile
            </div>

            <div class="card-body">
                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}"
                            required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}"
                            required>
                    </div>

                    <button type="submit" class="btn btn-success">
                        Save Changes 🌿
                    </button>
                </form>
            </div>
        </div>

    </div>

@endsection
