@extends('layouts.app')

@section('title', 'Manage Admins')
@section('page_title', 'Admins / Manage')

@section('styles')
    <style>
        .edit-row{
            background: rgba(15, 23, 42, .02);
        }
        .inline-form{
            display:grid;
            grid-template-columns: 1fr 1fr 220px;
            gap: 10px;
            align-items:end;
        }
        @media (max-width: 980px){
            .inline-form{ grid-template-columns: 1fr; }
        }
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
        .small-muted{ font-size: 12px; color: var(--muted); }
    </style>
@endsection

@section('content')
    <div class="grid">
        <div class="card">
            <div class="card-header">
                <div>
                    <div style="font-weight:700;">Manage Admins</div>
                    <div class="muted" style="font-size:13px;">Update or delete admins.</div>
                </div>
                <div style="display:flex; gap:10px;">
                    <a class="btn" href="{{ url('/admins') }}">View</a>
                    <a class="btn btn-primary" href="{{ url('/admins/create') }}">Create</a>
                </div>
            </div>

            <div class="card-body" style="padding:0;">
                <table>
                    <thead>
                        <tr>
                            <th style="width:90px;">ID</th>
                            <th>Email</th>
                            <th style="width:120px;">Active</th>
                            <th style="width:240px; text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $a)
                            <tr>
                                <td>{{ $a->admin_id }}</td>
                                <td style="font-weight:600;">{{ $a->admin_email }}</td>
                                <td>{{ $a->isActive ? 'Yes' : 'No' }}</td>
                                <td>
                                    <div class="row-actions">
                                        <button class="btn" type="button" data-toggle="edit-{{ $a->admin_id }}">Edit</button>
                                        <form method="POST" action="{{ route('admins.destroy', $a->admin_id) }}"
                                              onsubmit="return confirm('Delete this admin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr class="edit-row" id="edit-{{ $a->admin_id }}" style="display:none;">
                                <td colspan="4">
                                    <div style="padding: 12px;">
                                        <form method="POST" action="{{ route('admins.update', $a->admin_id) }}">
                                            @csrf
                                            @method('PUT')

                                            <div class="inline-form">
                                                <div class="field" style="margin:0;">
                                                    <label for="admin_email-{{ $a->admin_id }}">Email</label>
                                                    <input id="admin_email-{{ $a->admin_id }}" name="admin_email" type="email" value="{{ old('admin_email', $a->admin_email) }}" required>
                                                </div>

                                                <div class="field" style="margin:0;">
                                                    <label for="admin_password-{{ $a->admin_id }}">New password <span class="small-muted">(optional)</span></label>
                                                    <input id="admin_password-{{ $a->admin_id }}" name="admin_password" type="password" autocomplete="new-password">
                                                </div>

                                                <div class="field" style="margin:0;">
                                                    <label>Active</label>
                                                    <div class="checkbox-row">
                                                        <input id="isActive-{{ $a->admin_id }}" name="isActive" type="checkbox" value="1" {{ old('isActive', $a->isActive) ? 'checked' : '' }}>
                                                        <label for="isActive-{{ $a->admin_id }}" style="margin:0; color: var(--text);">Enabled</label>
                                                    </div>
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
                                    No admins found.
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

