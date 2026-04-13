<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Specialization;
use App\Models\DoctorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role', 'all');

        $query = User::query();

        if ($role !== 'all') {
            $query->where('role', $role);
        }

        $users = $query->with('doctorProfile.specialization')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'total' => User::count(),
            'admins' => User::admins()->count(),
            'doctors' => User::doctors()->count(),
            'members' => User::members()->count(),
        ];

        return view('admin.users.index', compact('users', 'stats', 'role'));
    }

    public function show(User $user)
    {
        $user->load(['doctorProfile.specialization', 'articles', 'memberAppointments', 'doctorAppointments']);

        return view('admin.users.show', compact('user'));
    }

    public function create()
    {
        $specializations = Specialization::orderBy('name')->get();
        return view('admin.users.create', compact('specializations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,doctor,member',
            'phone' => 'nullable|string|max:20',
            'specialization_id' => 'required_if:role,doctor|exists:specializations,id',
            'experience_years' => 'required_if:role,doctor|integer|min:0',
            'str_number' => 'required_if:role,doctor|string|max:50',
        ]);

        $userId = Str::uuid();

        $user = User::create([
            'id' => $userId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
        ]);

        if ($validated['role'] === 'doctor') {
            DoctorProfile::create([
                'user_id' => $userId,
                'specialization_id' => $validated['specialization_id'],
                'experience_years' => $validated['experience_years'],
                'str_number' => $validated['str_number'],
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $user->load('doctorProfile');
        $specializations = Specialization::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'specializations'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,doctor,member',
            'phone' => 'nullable|string|max:20',
            'specialization_id' => 'required_if:role,doctor|exists:specializations,id',
            'experience_years' => 'required_if:role,doctor|integer|min:0',
            'str_number' => 'required_if:role,doctor|string|max:50',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        // Update or create doctor profile
        if ($validated['role'] === 'doctor') {
            DoctorProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'specialization_id' => $validated['specialization_id'],
                    'experience_years' => $validated['experience_years'],
                    'str_number' => $validated['str_number'],
                ]
            );
        } else {
            // Remove doctor profile if role changed from doctor
            $user->doctorProfile()->delete();
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
