<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Appointment $appointment)
    {
        $messages = Message::with('sender')
            ->where('appointment_id', $appointment->id)
            ->orderBy('created_at')
            ->get();

        if (auth()->user()->role == 'doctor') {
            return view('chat.doctor', compact('appointment', 'messages'));
        }

        return view('chat.member', compact('appointment', 'messages'));
    }

    public function getMessages(Appointment $appointment)
    {
        $messages = Message::with('sender')
            ->where('appointment_id', $appointment->id)
            ->orderBy('created_at')
            ->get();

        return view(
            'chat.message',
            compact('messages')
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
        $appointment = Appointment::find($request->appointment_id);

        if ($appointment->status != "confirmed") {
            return response()->json([
                'status' => 'error'
            ]);
        }
        $message = new Message();
        $message->appointment_id = $request->appointment_id;
        $message->sender_id = auth()->id();
        $message->message = $request->message;

        $message->save();

        return response()->json([
            'status' => 'oke'
        ]);
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
        return view('chat.show', compact('appointment'));
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
