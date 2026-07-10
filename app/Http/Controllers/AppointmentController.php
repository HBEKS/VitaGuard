<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = Appointment::with([
            'member',
            'doctor',
            'service'
        ]);

        // Jika login sebagai doctor, hanya tampilkan appointment miliknya
        if (Auth::user()->role == 'doctor') {
            $query->where('doctor_id', Auth::id());
        }

        // Filter status
        if ($status != 'all') {
            $query->where('status', $status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('member', function ($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhereHas('doctor', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $appointments = $query
            ->orderBy('id', 'asc')
            ->paginate(5);

        $statsQuery = Appointment::query();

        if (Auth::user()->role == 'doctor') {
            $statsQuery->where('doctor_id', Auth::id());
        }

        $stats = [
            'total' => (clone $statsQuery)->count(),
            'pending' => (clone $statsQuery)->where('status', 'pending')->count(),
            'confirmed' => (clone $statsQuery)->where('status', 'confirmed')->count(),
            'completed' => (clone $statsQuery)->where('status', 'completed')->count(),
            // yang ini buat member aja yang mau cancel appointment
            'cancelled' => (clone $statsQuery)->where('status', 'cancelled')->count(),
        ];

        return view('booking.index', compact(
            'appointments',
            'stats',
            'status'
        ));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load([
            'member',
            'doctor.doctorProfile.specialization',
            'messages.sender',
            'transaction'
        ]);

        return view('booking.show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $appointment = Appointment::findOrFail($request->id);

        if (
            $appointment->status == 'pending' &&
            $request->status == 'confirmed'
        ) {

            $appointment->status = 'confirmed';
        } elseif (
            $appointment->status == 'confirmed' &&
            $request->status == 'completed'
        ) {

            $appointment->status = 'completed';
        } else {

            return response()->json([
                'status' => 'error',
                'message' => 'Status tidak valid.'
            ], 422);
        }

        $appointment->save();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function saveNotes(Request $request)
    {
        $appointment = Appointment::findOrFail($request->id);
        // Tidak boleh edit notes jika appointment sudah selesai atau dibatalkan
        if ($appointment->status == 'completed' && $appointment->status == 'cancelled') {
            return response()->json([
                'status' => 'error',
                'message' => 'Doctor notes tidak dapat diubah karena appointment sudah completed atau cancelled.'
            ], 403);
        }
        $appointment->doctor_notes = $request->doctor_notes;
        $appointment->save();
        return response()->json([
            'status' => 'success'
        ]);
    }
}
