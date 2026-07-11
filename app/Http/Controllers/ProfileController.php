<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class profileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(/*$id*/)
    {
        $user = User::with([
            'doctorProfile.specialization',
            'doctorProfile.services'
        ])->find(Auth::id());

        return view('profile.index', compact('user'));
    }

    public function indexMember()
    {
        $user = Auth::user();
        return view('member.profile', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {

        $user = User::findOrFail(Auth::id());
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail(Auth::id());

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        // Update password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update avatar
        if ($request->hasFile('avatar')) {
            //hapus profile yang lama
            if ($user->avatar && File::exists(public_path('storage/' . $user->avatar))) {
                File::delete(public_path('storage/' . $user->avatar));
            }

            $file = $request->file('avatar');

            //nama file
            $filename = 'user-' . $user->id . "." . $file->getClientOriginalExtension();

            //simpan
            $file->move(
                public_path('storage/img/profiles/'),
                $filename
            );

            //simpan ke database
            $user->avatar = 'img/profiles/' . $filename;
        }

        $user->save();

        if (ob_get_length()) {
            ob_clean();
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * AJAX: Tampilkan Form Edit Profile Member
     */
    public function editMember(Request $request)
    {
        $user = Auth::user();
        return view('member.editMember', compact('user'));
    }

    /**
     * AJAX: Simpan Perubahan Profile Member
     */
    public function updateMember(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail(Auth::id());

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Update password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update avatar
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && File::exists(public_path('storage/' . $user->avatar))) {
                File::delete(public_path('storage/' . $user->avatar));
            }

            $file = $request->file('avatar');

            // Format nama file unik berdasarkan ID user
            $filename = 'user-' . $user->id . '.' . $file->getClientOriginalExtension();

            // Simpan file ke folder public/storage/img/profiles/
            $file->move(
                public_path('storage/img/profiles/'),
                $filename
            );

            // Simpan path relatif ke database
            $user->avatar = 'img/profiles/' . $filename;
        }

        $user->save();

        // Membersihkan output buffer jika ada whitespace liar
        if (ob_get_length()) {
            ob_clean();
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
