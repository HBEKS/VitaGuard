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

        return view(
            'chat.index',
            compact(
                'appointment',
                'messages'
            )
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
        $appointment = Appointment::findOrFail($request->appointment_id);

        // Chat dikunci jika appointment sudah selesai atau dibatalkan
        if (in_array($appointment->status, ['completed', 'cancelled'])) {
            return redirect()->back()->with(
                'error',
                'Chat sudah ditutup karena appointment telah ' . $appointment->status . '.'
            );
        }

        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        Message::create([
            'appointment_id' => $appointment->id,
            'sender_id'      => auth()->id(),
            'message'        => $request->message,
        ]);
        return redirect()->back();
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
