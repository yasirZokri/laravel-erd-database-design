@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
    <h2 class="mb-4">Users</h2>

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>

                            <td class="d-flex gap-2 text-nowrap">
                                {{-- Edit --}}
                                <a href="{{ route('get.user.update', $user->id) }}" class="btn btn-sm btn-warning">
                                    Update
                                    </a>


                                    {{-- Delete --}}
                                    <form action="{{ route('user.delete', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                No users found 🌿
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>
@endsection
