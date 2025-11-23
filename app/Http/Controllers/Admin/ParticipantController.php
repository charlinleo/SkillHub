<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $peserta = User::where('role', 'peserta')
            ->with(['enrollments.skillClass'])
            ->paginate(10);

        return view('admin.participants.index', compact('peserta'));
    }

    public function create()
    {
        return view('admin.participants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $validated['password'] = bcrypt('password123');
        $validated['role'] = 'peserta';

        User::create($validated);

        return redirect()->route('admin.participants.index')
            ->with('success', 'Peserta berhasil ditambahkan');
    }

    public function edit(User $participant)
    {
        abort_unless($participant->isPeserta(), 404);
        $peserta = $participant;
        return view('admin.participants.edit', compact('peserta'));
    }

    public function update(Request $request, User $participant)
    {
        abort_unless($participant->isPeserta(), 404);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $participant->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $participant->update($validated);

        return redirect()->route('admin.participants.index')
            ->with('success', 'Data peserta diperbarui');
    }

    public function destroy(User $participant)
    {
        abort_unless($participant->isPeserta(), 404);
        $participant->delete();

        return back()->with('success', 'Peserta dihapus');
    }
}
