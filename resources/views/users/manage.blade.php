@extends('layouts.app')

@section('title', 'Manage Users')
@section('page_title', 'Users / Manage')

@section('content')
    <div class="grid">
        <div class="card">
            <div class="card-header">
                <div>
                    <div style="font-weight:700;">Manage Users</div>
                    <div class="muted" style="font-size:13px;">Update or delete users.</div>
                </div>
                <div style="display:flex; gap:10px;">
                    <a class="btn" href="{{ url('/users') }}">View</a>
                    <a class="btn btn-primary" href="{{ url('/users/create') }}">Create</a>
                </div>
            </div>

            <div class="card-body" style="padding:0;">
                <table>
                    <thead>
                        <tr>
                            <th style="width:90px;">ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th style="width:220px; text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                            <tr>
                                <td>{{ $u->id }}</td>
                                <td style="font-weight:600;">{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    <div class="row-actions">
                                        <button class="btn" type="button" data-toggle="edit-{{ $u->id }}">Edit</button>
                                        <form method="POST" action="{{ route('users.destroy', $u->id) }}"
                                              onsubmit="return confirm('Delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr class="edit-row" id="edit-{{ $u->id }}" style="display:none;">
                                <td colspan="4">
                                    <div style="padding: 12px;">
                                        <form method="POST" action="{{ route('users.update', $u->id) }}">
                                            @csrf
                                            @method('PUT')

                                            <div class="inline-form">
                                                <div class="field" style="margin:0;">
                                                    <label for="name-{{ $u->id }}">Name</label>
                                                    <input id="name-{{ $u->id }}" name="name" type="text" value="{{ old('name', $u->name) }}" required>
                                                </div>

                                                <div class="field" style="margin:0;">
                                                    <label for="email-{{ $u->id }}">Email</label>
                                                    <input id="email-{{ $u->id }}" name="email" type="email" value="{{ old('email', $u->email) }}" required>
                                                </div>

                                                <div class="field" style="margin:0;">
                                                    <label for="password-{{ $u->id }}">New password <span class="small-muted">(optional)</span></label>
                                                    <input id="password-{{ $u->id }}" name="password" type="password" autocomplete="new-password">
                                                </div>
                                            </div>

                                            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top: 10px;">
                                                <button class="btn btn-primary" type="submit">Save</button>
                                            </div>

                                            @if ($errors->any())
                                                <div class="small-muted" style="margin-top:10px;">
                                                    If validation fails, errors will show on top after submit.
                                                </div>
                                            @endif
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="muted" style="text-align:center; padding: 18px;">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function () {
            document.querySelectorAll('[data-toggle]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.getAttribute('data-toggle');
                    const row = document.getElementById(id);
                    if (!row) return;
                    row.style.display = (row.style.display === 'none' || !row.style.display) ? 'table-row' : 'none';
                });
            });
        })();
    </script>
@endsection

