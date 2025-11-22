<?php

namespace App\Http\Controllers\Admin;

use App\Models\Enrollment;
use App\Http\Controllers\Controller;
use App\Models\SkillClass;
use App\Models\User;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $enrollments = Enrollment::with(['peserta', 'skillClass'])
            ->orderBy('status')
            ->latest()
            ->paginate(15);

        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function updateStatus(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,active,denied',
        ]);
        if ($validated['status'] === 'denied') {
            $enrollment->delete();

            return back()->with(
                'success',
                'Pendaftaran peserta telah ditolak dan dihapus. Peserta harus mendaftar ulang jika ingin ikut kelas ini lagi.'
            );
        }

        // Selain itu (pending / active), cukup update status
        $enrollment->status = $validated['status'];
        $enrollment->save();

        return back()->with('success', 'Status pendaftaran diperbarui.');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return back()->with('success', 'Pendaftaran dihapus');
    }

    public function storeForClass(Request $request, SkillClass $class)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::where('id', $validated['user_id'])
            ->where('role', 'peserta')
            ->firstOrFail();

        $exists = Enrollment::where('user_id', $user->id)
            ->where('class_id', $class->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Peserta ini sudah terdaftar di kelas ini.');
        }

        Enrollment::create([
            'user_id' => $user->id,
            'class_id' => $class->id,
            'status' => 'active', // atau 'pending' kalau mau
        ]);

        return back()->with('success', 'Peserta berhasil ditambahkan ke kelas.');
    }
}
