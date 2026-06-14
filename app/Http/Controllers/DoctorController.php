<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoctorProfile;
use App\Models\Specialization;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = DoctorProfile::with(['user', 'specialization', 'services'])->get();
        return view('doctor.index', compact('doctors'));
    }
    //
    public function deleteData(Request $request)
    {
        $id = $request->id;
        $data = DoctorProfile::find($id);
        $data->delete();
        return response()->json(['status' => 'oke', 'msg' => 'Doctor deleted!'], 200);
    }
    
        public function getEditFormB(Request $request)
    {
        $id = $request->id;
        $data = DoctorProfile::with(['user', 'specialization', 'services'])->find($id);
        $specializations = Specialization::all();
        return response()->json([
            'status' => 'oke',
            'msg' => view('doctor.getEditFormB', compact('data', 'specializations'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $data = DoctorProfile::find($id);
        $data->experience_years = $request->experience_years;
        $data->specialization_id = $request->specialization_id;
        $data->str_number = $request->str_number;
        $data->save();

        $specializationName = $data->specialization->name;

        return response()->json([
            'status' => 'oke',
            'specialization_name' => $specializationName,
            'msg' => 'Doctor updated!'
        ], 200);
    }
    //

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
