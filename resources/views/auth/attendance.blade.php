@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <form action="{{ route('post.attendance') }}" method="POST" class="container-fluid mt-4">
        @csrf

        <div class="card shadow-sm border-success">
            <div class="card-header bg-success text-white text-center">
                <h5 class="mb-0">🌱 Attendance Sheet</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-success text-center">
                            <tr>
                                <th>User Name</th>
                                <th>Status</th>
                                <th>Details</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $user->name }}
                                    </td>

                                    <td>
                                        <select name="attendance[{{ $user->id }}]" class="form-select border-success">
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->id }}">
                                                    {{ $status->type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <textarea name="details[{{ $user->id }}]" class="form-control border-success" rows="2"
                                            placeholder="Optional notes..."></textarea>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success px-4">
                        💾 Save Attendance
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
