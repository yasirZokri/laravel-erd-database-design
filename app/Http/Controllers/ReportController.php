<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::query()
            ->latest('created_at')
            ->take(100)
            ->get();

        return view('reports.index', compact('reports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:daily,weekly,monthly'],
            'data' => ['required', 'json'],
        ]);

        Report::create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'data' => json_decode($validated['data'], true),
        ]);

        return back()->with('success', 'Report created successfully.');
    }
}

