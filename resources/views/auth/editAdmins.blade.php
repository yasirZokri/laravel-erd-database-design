@extends('layouts.dashboard')

@section('title', 'Admins')

@section('content')
    <h2 class="mb-4">Admins</h2>

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>isActive</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $admin->admin_id }}</td>
                            <td>{{ $admin->admin_email }}</td>
                            <td>{{ $admin->isActive }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
