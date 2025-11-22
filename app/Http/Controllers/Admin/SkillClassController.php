<?php

namespace App\Http\Controllers\Admin;

use App\Models\SkillClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SkillClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $classes = SkillClass::paginate(10);

        $enrolledClassIds = [];
        return view('classes.index', compact('classes', 'enrolledClassIds'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor_name' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
        ]);

        SkillClass::create($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Kelas berhasil ditambahkan');
    }

    public function edit(SkillClass $class)
    {
        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, SkillClass $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor_name' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
        ]);

        $class->update($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Kelas diperbarui');
    }

    public function destroy(SkillClass $class)
    {
        // Aturan: jika kelas dihapus, semua enrollment terkait ikut hilang
        $class->delete();
        return back()->with('success', 'Kelas dihapus');
    }
}
