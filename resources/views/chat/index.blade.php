@extends('layouts.adminlte4')
@section('title', 'Messages')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('booking') }}">Appointments</a>
</li>
<li class="breadcrumb-item active">Chat</li>
@endsection

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                Chat
            </h4>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <strong>Doctor :</strong>
                {{ $appointment->doctor->name }}
                <br>
                <strong>Patient :</strong>
                {{ $appointment->member->name }}
                <br>
                <strong>Service :</strong>
                {{ $appointment->service->service_name }}
            </div>

            <hr>
            {{-- CHAT AREA --}}
            <div
                id="chat-box"
                class="border rounded p-3 mb-3"
                style="height:450px; overflow-y:auto; background:#f8f9fa;">
                @forelse($messages as $message)
                <div class="mb-3">
                    <strong>
                        {{ $message->sender->name }}
                    </strong>
                    <br>
                    <div class="border rounded p-2 bg-white">
                        {{ $message->message }}
                    </div>
                    <small class="text-muted">
                        {{ $message->created_at->format('d M Y H:i') }}
                    </small>
                </div>
                @empty
                <div class="text-center text-muted">
                    Belum ada percakapan.
                </div>
                @endforelse
            </div>
            {{-- FORM CHAT --}}
            @if(in_array($appointment->status, ['pending','confirmed']))

            <form action="{{ route('chat.send') }}" method="POST">
                @csrf

                <input type="hidden"
                    name="appointment_id"
                    value="{{ $appointment->id }}">

                <textarea
                    name="message"
                    class="form-control"
                    placeholder="Type your message..."></textarea>

                <button
                    type="submit"
                    class="btn btn-primary mt-2">
                    Send
                </button>
            </form>

            @else

            <div class="alert alert-secondary mt-3">
                <i class="bi bi-lock-fill"></i>
                Chat telah ditutup karena appointment sudah
                <strong>{{ ucfirst($appointment->status) }}</strong>.
            </div>

            @endif
        </div>
    </div>
</div>
@endsection
