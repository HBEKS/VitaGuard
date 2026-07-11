<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $allSchedules = Schedule::where('doctor_id', Auth::id())
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->paginate($perPage);

        return view(
            'doctor.schedule.index',
            compact('allSchedules')
        );
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

        $schedule = new Schedule();

        $schedule->doctor_id = Auth::id();
        $schedule->day_of_week = $request->day_of_week;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->is_active = $request->has('is_active');

        $schedule->save();

        return redirect()->route('doctor.schedule.index')
            ->with('success', 'Schedule added successfully.');
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

    public function saveDataUpdate(Request $request)
    {
        $schedule = Schedule::find($request->id);

        $schedule->day_of_week = $request->day_of_week;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->is_active = $request->is_active;

        $schedule->save();

        return response()->json([
            'status' => 'oke',
            'msg' => 'Schedule updated'
        ]);
    }

    public function deleteData(Request $request)
    {
        Schedule::find($request->id)->delete();

        return response()->json([
            'status' => 'oke',
            'msg' => 'Schedule deleted.'
        ], 200);
    }

    public function getEditFormB(Request $request)
    {
        $schedule = Schedule::find($request->id);

        return response()->json([
            'status' => 'oke',
            'msg' => view('doctor.schedule.getEditForm', compact('schedule'))->render()
        ], 200);
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
