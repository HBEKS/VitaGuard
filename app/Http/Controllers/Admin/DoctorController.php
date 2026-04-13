<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Specialization;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::doctors()
            ->with(['doctorProfile.specialization', 'schedules'])
            ->withCount(['doctorAppointments as total_appointments'])
            ->withCount(['doctorAppointments as completed_appointments' => function ($q) {
                $q->where('status', 'completed');
            }]);

        // Filter by specialization
        if ($request->has('specialization')) {
            $query->whereHas('doctorProfile', function ($q) use ($request) {
                $q->where('specialization_id', $request->specialization);
            });
        }

        $doctors = $query->orderBy('name')->paginate(12);

        $specializations = Specialization::orderBy('name')->get();

        return view('admin.doctors.index', compact('doctors', 'specializations'));
    }

    public function show(User $doctor)
    {
        $doctor->load([
            'doctorProfile.specialization',
            'schedules',
            'doctorAppointments' => function ($q) {
                $q->with('member')->latest()->take(10);
            }
        ]);

        $doctor->loadCount([
            'doctorAppointments as total_appointments',
            'doctorAppointments as completed_appointments' => function ($q) {
                $q->where('status', 'completed');
            },
            'doctorAppointments as pending_appointments' => function ($q) {
                $q->where('status', 'pending');
            }
        ]);

        return view('admin.doctors.show', compact('doctor'));
    }

    public function schedules(User $doctor)
    {
        $schedules = $doctor->schedules()->orderBy('day_of_week')->orderBy('start_time')->get();

        return view('admin.doctors.schedules', compact('doctor', 'schedules'));
    }
}
