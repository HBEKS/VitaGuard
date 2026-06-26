@extends('layouts.adminlte4')
@section('title', 'Appointments')
@section('sidebar-booking', 'active')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Appointments with
        {{Auth::user()->name}}
    </h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Patient</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Patient Complaint</th>
                    <th>Doctor Notes</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- isi tabel -->
                @foreach ($appointments as $a)
                <tr id="tr_{{ $a->id }}">
                    <td class="text-center"><span class="badge bg-secondary">{{ $a->id }}</span></td>
                    <!-- nama pasien -->
                    <td>{{ $a->member->name ?? '-' }}</td>

                    <!-- nama servis -->
                    <td>
                        @php
                        $isValidService = DB::table('doctor_service')
                        ->where('doctor_profile_id', $a->doctor->doctorProfile?->id)
                        ->where('service_id', $a->service_id)
                        ->exists();
                        @endphp
                        <span class="badge {{ $isValidService ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $a->service->service_name ?? '-' }}
                        </span>
                    </td>

                    <!-- tanggal appointment -->
                    <td id="td_date_{{ $a->id }}">{{ $a->appointment_date->format('d-m-Y') }}</td>

                    <!-- jam appointment -->
                    <td id="td_time_{{$a->id}}">{{ $a->appointment_time->format('H:i')}}</td>

                    <!-- complaint pasien -->
                    <td id="patient_complaint{{$a->id}}">{{$a->member_complaint}}</td>

                    <!-- doctor notes -->
                    <td id="doctor_notes{{$a->id}}">
                        @if(!empty($a->doctor_notes))
                        {{ $a->doctor_notes }}
                        @else
                        <i class="text-muted">Belum ada notes</i>
                        @endif
                    </td>

                    <!-- status -->
                    <td id="td_status_{{ $a->id }}">
                        @php
                        $statusColors = [
                        'pending' => 'warning',
                        'confirmed' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$a->status] ?? 'secondary' }}">
                            {{ $a->status }}
                        </span>
                    </td>

                    <!-- action -->
                    <td class="text-center">
                        <!-- doctor -->
                        @if(Auth::user()->role=="doctor")
                        {{-- Change Status --}}
                        <form action="{{ route('appointment.updateStatus', $a->id) }}"
                            method="POST"
                            class="mb-2">
                            @csrf
                            @method('PUT')

                            @if($a->status=="pending")
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" class="btn btn-warning btn-sm w-100">
                                Pending
                            </button>

                            @elseif($a->status=="confirmed")
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                Confirmed
                            </button>

                            @elseif($a->status=="completed")
                            <button type="button" class="btn btn-success btn-sm w-100" disabled>
                                Completed
                            </button>
                            @else

                            <button type="button" class="btn btn-danger btn-sm w-100" disabled>
                                Cancelled
                            </button>
                            @endif
                        </form>

                        {{-- Chat --}}
                        <a href="{{ route('chat.show', $a->id) }}"
                            class="btn btn-info btn-sm w-100 mb-2">
                            <i class="bi bi-chat-dots"></i> Chat
                        </a>

                        {{-- Notes --}}
                        @php
                        $notes = addslashes($a->doctor_notes ?? '');
                        @endphp

                        <button
                            class="btn btn-secondary btn-sm w-100"
                            onclick="showNotesModal('{{ $a->id }}','{{ $notes }}')">

                            <i class="bi bi-journal-medical"></i>

                            {{ $a->doctor_notes ? 'Edit Notes' : 'Add Notes' }}

                        </button>

                        @endif

                        <!-- admin -->
                        @if(Auth::user()->role=="admin")
                        <a href="#modalEditB" class="btn btn-sm btn-primary mb-1" data-bs-toggle="modal"
                            onclick="getEditFormB('{{ $a->id }}')">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger"
                            onclick="if(confirm('Hapus appointment ini?')) deleteDataRemove('{{ $a->id }}')">Delete</a>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <hr class="my-4">
    @if(Auth::user()->role=="admin")
    <div class="d-flex gap-3 justify-content-center">
        <a href="{{ url('dashboard/transaction') }}" class="btn btn-warning">View Transactions</a>
        <a href="{{ url('/') }}" class="btn btn-outline-dark">Back to Home</a>
    </div>
    @endif
</div>

@endsection

@push('script')
<script>
    function getEditFormB(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("appointment.getEditFormB") }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id
            },
            success: function(data) {
                $('#modalContentB').html(data.msg);
            }
        });
    }

    function saveDataUpdate(id) {
        var status = $('#edit_status').val();
        var appointment_date = $('#edit_appointment_date').val();
        var doctor_notes = $('#edit_doctor_notes').val();

        $.ajax({
            type: 'POST',
            url: '{{ route("appointment.saveDataUpdate") }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id,
                'status': status,
                'appointment_date': appointment_date,
                'doctor_notes': doctor_notes
            },
            success: function(data) {
                if (data.status == "oke") {
                    var colors = {
                        'pending': 'warning',
                        'confirmed': 'primary',
                        'completed': 'success',
                        'cancelled': 'danger'
                    };
                    $('#td_status_' + id).html('<span class="badge bg-' + (colors[data.new_status] || 'secondary') + '">' + data.new_status + '</span>');
                    $('#td_date_' + id).html(data.new_date);
                    $('#modalEditB').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                }
            }
        });
    }

    function deleteDataRemove(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("appointment.deleteData") }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id
            },
            success: function(data) {
                if (data.status == "oke") {
                    $('#tr_' + id).remove();
                }
            }
        });
    }
</script>
@endpush