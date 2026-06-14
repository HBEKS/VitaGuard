<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Service;
class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with(['doctor', 'member', 'service'])->get();

        return view('appointment.index', compact('appointments'));
    }
    public function getEditFormB(Request $request)
    {
        $id = $request->id;
        $data = Appointment::with(['doctor', 'member', 'service'])->find($id);
        $services = Service::all();
        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        return response()->json([
            'status' => 'oke',
            'msg' => view('appointment.getEditFormB', compact('data', 'services', 'statuses'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $data = Appointment::find($id);
        $data->status = $request->status;
        $data->appointment_date = $request->appointment_date;
        $data->doctor_notes = $request->doctor_notes;
        $data->save();

        return response()->json([
            'status' => 'oke',
            'new_status' => $data->status,
            'new_date' => $data->appointment_date->format('Y-m-d'),
            'msg' => 'Appointment updated!'
        ], 200);
    }

    public function deleteData(Request $request)
    {
        $id = $request->id;
        $data = Appointment::find($id);
        $data->delete();
        return response()->json(['status' => 'oke', 'msg' => 'Appointment deleted!'], 200);
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
