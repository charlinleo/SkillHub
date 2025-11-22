<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SkillClass;
use App\Models\Enrollment;

class ClassBrowseController extends Controller
{
    public function __construct()
    {
        // index & show bisa diakses guest; enroll, myClasses, cancel wajib login
        $this->middleware('auth')->only(['enroll', 'myClasses', 'cancel']);
    }

    public function index()
    {
        $classes = SkillClass::paginate(10);

        $enrollmentStatuses = [];
        $enrolledClassIds = [];

        if (auth()->check() && auth()->user()->isPeserta()) {
            // array: [class_id => status]
            $enrollmentStatuses = auth()->user()
                ->enrollments()
                ->pluck('status', 'class_id')
                ->toArray();

            // array: [class_id1, class_id2, ...]
            $enrolledClassIds = array_keys($enrollmentStatuses);
        }

        return view('classes.index', compact('classes', 'enrollmentStatuses', 'enrolledClassIds'));
    }
    public function show(SkillClass $class)
    {

        $class->load(['enrollments.peserta']);

        $userEnrollment = null;

        if (auth()->check() && auth()->user()->isPeserta()) {
            $user = auth()->user();

            $userEnrollment = Enrollment::where('user_id', $user->id)
                ->where('class_id', $class->id)
                ->first(); // jangan toArray biar bisa pakai ->status di Blade
        }

        $enrolledClassIds = [];
        if (auth()->check()) {
            $enrolledClassIds = auth()->user()
                ->enrollments()
                ->pluck('status', 'class_id')
                ->toArray();
        }

        $availableParticipants = collect();
        if (auth()->check() && auth()->user()->isAdmin()) {
            $availableParticipants = User::where('role', 'peserta')
                ->whereDoesntHave('enrollments', function ($q) use ($class) {
                    $q->where('class_id', $class->id);
                })
                ->orderBy('name')
                ->get();
        }

        return view('classes.show', compact(
            'class',
            'userEnrollment',
            'enrolledClassIds',
            'availableParticipants'
        ));
    }

    public function enroll(Request $request, SkillClass $class)
    {
        $user = auth()->user();

        // Cegah duplikasi
        $existing = Enrollment::where('user_id', $user->id)
            ->where('class_id', $class->id)
            ->first();
        if ($existing) {
            return back()->with('error', 'Anda sudah pernah mendaftar ke kelas ini.');
        }

        Enrollment::create([
            'user_id' => $user->id,
            'class_id' => $class->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pendaftaran dikirim. Menunggu persetujuan admin.');
    }

    public function myClasses()
    {
        $user = auth()->user();
        $enrollments = $user->enrollments()->with('skillClass')->get();

        return view('participant.my_classes', compact('enrollments'));
    }

    public function cancel(Enrollment $enrollment)
    {
        $user = auth()->user();

        abort_unless($enrollment->user_id === $user->id, 403);

        $enrollment->delete();

        return back()->with('success', 'Pendaftaran berhasil dibatalkan.');
    }
}
