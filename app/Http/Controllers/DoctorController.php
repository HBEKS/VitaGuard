<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Specialization;
use Illuminate\Http\Request;
use App\Models\DoctorProfile;
use App\Models\Service; 

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
        $members = User::where('role', 'member')->orderBy('name')->get();
        $doctors = $query->orderBy('name')->paginate(5);
        $specializations = Specialization::orderBy('name')->get();
        return view('doctor.index', compact('doctors', 'specializations', 'members'));;

    }
    public function getEditFormB(Request $request)
    {
        $doctor = User::with(['doctorProfile.specialization', 'doctorProfile.services'])->find($request->id);
        $specializations = Specialization::orderBy('name')->get();
        $services = Service::orderBy('service_name')->get();
        return response()->json([
            'status' => 'oke',
            'msg' => view('doctor.getEditFormB', compact('doctor', 'specializations', 'services'))->render()
        ], 200);
    }
    public function saveDataUpdate(Request $request)
    {
        $profile = DoctorProfile::where('user_id', $request->id)->first();
        $profile->specialization_id = $request->specialization_id;
        $profile->experience_years  = $request->experience_years;
        $profile->str_number        = $request->str_number;
        $profile->save();
        $profile->services()->sync($request->service_ids ?? []);
        return response()->json(['status' => 'oke', 'msg' => 'Doctor updated!'], 200);
    }
    public function store(Request $request)
    {
        $user = User::find($request->user_id);
        $user->role = 'doctor';
        $user->save();

        DoctorProfile::create([
            'user_id'           => $user->id,
            'specialization_id' => $request->specialization_id,
            'experience_years'  => $request->experience_years,
            'str_number'        => $request->str_number,
        ]);

        return redirect()->route('listDoctor.index')->with('success', 'Doctor added!');
    }

    public function deleteData(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        return response()->json(['status' => 'oke', 'msg' => 'Doctor deleted!'], 200);
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
