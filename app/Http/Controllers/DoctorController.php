<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Specialization;
use Illuminate\Http\Request;
use App\Models\DoctorProfile;
use App\Models\Service;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        //$members = User::where('role', 'member')->orderBy('name')->get();
        $doctors = $query->orderBy('name')->paginate(5);
        $specializations = Specialization::orderBy('name')->get();

        $services = Service::orderBy('service_name')->get();

        return view('doctor.index', compact('doctors', 'specializations', 'services'));;
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
        // buat user baru
        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);
        $user->role     = 'doctor';
        $user->save();

        // buat doctor profile
        DoctorProfile::create([
            'user_id'           => $user->id,
            'specialization_id' => $request->specialization_id,
            'experience_years'  => $request->experience_years,
            'str_number'        => $request->str_number,
        ]);

        // sync services kalau ada
        if ($request->service_ids) {
            $profile = DoctorProfile::where('user_id', $user->id)->first();
            $profile->services()->sync($request->service_ids);
        }

        return redirect()->route('listDoctor')->with('success', 'Doctor added!');
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

    public function dashboard()
    {
        $doctorId = Auth::id();

        $pending = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'pending')
            ->count();

        $confirmed = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'confirmed')
            ->count();

        $completed = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'completed')
            ->count();

        $cancelled = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'cancelled')
            ->count();

        $activePatients = Appointment::where('doctor_id', $doctorId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->distinct('member_id')
            ->count('member_id');

        $statusChart = [
            'Pending' => Appointment::where('doctor_id', $doctorId)
                ->where('status', 'pending')
                ->count(),

            'Confirmed' => Appointment::where('doctor_id', $doctorId)
                ->where('status', 'confirmed')
                ->count(),

            'Completed' => Appointment::where('doctor_id', $doctorId)
                ->where('status', 'completed')
                ->count(),

            'Cancelled' => Appointment::where('doctor_id', $doctorId)
                ->where('status', 'cancelled')
                ->count(),
        ];

        $monthlyChart = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyChart[] = [
                'month' => Carbon::create()->month($i)->format('M'),
                'count' => Appointment::where('doctor_id', $doctorId)
                    ->whereYear('appointment_date', now()->year)
                    ->whereMonth('appointment_date', $i)
                    ->count()
            ];
        }

        $serviceChart = Appointment::selectRaw('service_id, COUNT(*) as total')
            ->with('service')
            ->where('doctor_id', $doctorId)
            ->groupBy('service_id')
            ->get();

        $todayAppointments = Appointment::with(['member', 'service'])
            ->where('doctor_id', $doctorId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $recentAppointments = Appointment::with(['member', 'service'])
            ->where('doctor_id', $doctorId)
            ->latest('appointment_date')
            ->take(5)
            ->get();

        $total = Appointment::where('doctor_id', $doctorId)->count();



        return view('doctor.dashboard', compact(
            'pending',
            'confirmed',
            'completed',
            'activePatients',
            'total',
            'cancelled',

            'statusChart',
            'monthlyChart',
            'serviceChart',

            'todayAppointments',
            'recentAppointments'
        ));
    }
}
