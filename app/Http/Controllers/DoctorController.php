<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Specialization;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'doctor')
        ->with([
            'doctorProfile.specialization',
            'doctorProfile.services'
        ]);

        // Filter specialization (opsional)
        if ($request->filled('specialization')) {
            $query->whereHas('doctorProfile', function ($q) use ($request) {
                $q->where('specialization_id', $request->specialization);
            });
        }

        $doctors = $query->orderBy('name')->paginate(5);
        $specializations = Specialization::orderBy('name')->get();
        return view('doctor.index', compact('doctors', 'specializations'));

        
        $perPage = request('per_page',5);
        $doctors = $query
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();
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
