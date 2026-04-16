@extends('layouts.app')

@section('title', 'Reports')
@section('page_title', 'Reports')

@section('content')
    <div class="grid">
        <div class="card">
            <div class="card-header">
                <div>
                    <div style="font-weight:700;">Reports</div>
                    <div class="muted" style="font-size:13px;">Create simple JSON-backed reports.</div>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('reports.store') }}" class="form">
                    @csrf

                    <div class="field">
                        <label for="title">Title</label>
                        <input id="title" name="title" type="text" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="type">Type</label>
                        <select id="type" name="type" required>
                            <option value="" disabled {{ old('type') ? '' : 'selected' }}>Select</option>
                            <option value="daily" {{ old('type') === 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ old('type') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ old('type') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                        </select>
                        @error('type')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="data">Data (JSON)</label>
                        <input id="data" name="data" type="text" value="{{ old('data', '{\"kpi\": 1}') }}" required>
                        @error('data')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                        <div class="muted" style="font-size:12px; margin-top: 8px;">
                            Example: {"kpi": 1, "items": [1,2,3]}
                        </div>
                    </div>

                    <div style="display:flex; justify-content:flex-end; margin-top: 14px;">
                        <button class="btn btn-primary" type="submit">Create Report</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div>
                    <div style="font-weight:700;">Recent Reports</div>
                    <div class="muted" style="font-size:13px;">Latest 100.</div>
                </div>
            </div>
            <div class="card-body" style="padding:0;">
                <table>
                    <thead>
                        <tr>
                            <th style="width:180px;">Created</th>
                            <th style="width:220px;">Title</th>
                            <th style="width:120px;">Type</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $r)
                            <tr>
                                <td class="muted">{{ optional($r->created_at)->format('Y-m-d H:i:s') }}</td>
                                <td style="font-weight:600;">{{ $r->title }}</td>
                                <td>{{ $r->type }}</td>
                                <td class="muted" style="font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, \"Liberation Mono\", \"Courier New\", monospace; font-size: 12px;">
                                    {{ json_encode($r->data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="muted" style="text-align:center; padding: 18px;">
                                    No reports yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

