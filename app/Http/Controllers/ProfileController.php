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
        $user = Auth::user();
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

        $user = Auth::user();

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
                public_path('storage/profiles/'),
                $filename
            );

            //simpan ke database
            $user->avatar = 'profiles/' . $filename;
        }

        $user->save();

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
