<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Service;
use GuzzleHttp\Psr7\Response;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        return view('booking.index', [
            'appointments' => Appointment::paginate(10),
            'transactions' => Transaction::paginate(10),
        ]);
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

    public function saveNotes(Request $request)
    {
        $appointment = Appointment::find($request->id);

        $appointment->doctor_notes = $request->doctor_notes;
        $appointment->save();

        return response()->json([
            'status' => 'oke',
            'doctor_notes' => $appointment->doctor_notes
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
