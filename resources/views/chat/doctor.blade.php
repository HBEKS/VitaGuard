@extends('layouts.adminlte4')
@section('title', 'Messages')
@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('booking.index') }}">Appointments</a>
</li>
<li class="breadcrumb-item active">Chat</li>
@endsection

@section('content')
<section>
    <div class="container mt-4">

        <div class="card">

            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Chat</h4>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <strong>Patient :</strong>
                    {{ $appointment->member->name }}
                    <br>

                    <strong>Service :</strong>
                    {{ $appointment->service->service_name }}
                    <br>

                    <strong>Complaint :</strong>
                    {{ $appointment->member_complaint ?? '-' }}
                </div>

                <hr>

                <div id="chat-box" class="border rounded p-3 mb-3" style="height:450px; overflow-y:auto; background:#f8f9fa;">
                    @include('chat.message')
                </div>
                @if($appointment->status == 'confirmed')
                <input type="hidden" id="appointment_id" value="{{ $appointment->id }}">
                <textarea id="message"
                    class="form-control"
                    placeholder="Type your message..."></textarea>
                <button
                    type="button"
                    class="btn btn-primary mt-2"
                    onclick="sendMessage()">
                    Send
                </button>
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
</section>

@endsection

@push('script')
<script>
    function sendMessage() {
        var appointment_id = $('#appointment_id').val();
        var message = $('#message').val();
        $.ajax({
            type: 'POST',
            url: '{{ route("chat.send") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'appointment_id': appointment_id,
                'message': message
            },
            success: function(data) {
                if (data.status == "oke") {
                    $('#message').val('');
                    loadMessages();
                }
            }
        });
    }

    function loadMessages() {
        $.get(
            "{{ route('chat.messages', $appointment->id) }}",
            function(data) {
                $("#chat-box").html(data);
            }
        );
    }

    loadMessages();
    setInterval(function() {
        loadMessages();
    }, 3000);
</script>
@endpush