@extends('layouts.adminlte4')
@section('title', 'Appointments')
@section('sidebar-booking', 'active')

@section('content')
<div class="container mt-4">
    @if(Auth::user()->role=="doctor")
    <h1 class="mb-4">Appointments with
        {{Auth::user()->name}}
    </h1>
    @endif
    @if(Auth::user()->role=="admin")
    <h1 class="mb-4">All Appointments</h1>
    @endif

    <div class="table-responsive">
        <div class="d-flex justify-content-between align-items-center mb-3">

            <form method="GET">
                Show
                <select name="appointment_per_page"
                    onchange="this.form.submit()">

                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>

                </select>
                entries
            </form>

            {{ $appointments->links() }}

        </div>
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
                    @if(Auth::user()->role=="doctor")
                    <th>Action</th>
                    @endif
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
                        @if($a->status=="pending")

                        <button
                            type="button"
                            class="btn btn-warning btn-sm w-100 mb-2"
                            onclick="changeStatus({{ $a->id }}, 'confirmed')">
                            Pending
                        </button>

                        @elseif($a->status=="confirmed")

                        <button
                            type="button"
                            class="btn btn-primary btn-sm w-100 mb-2"
                            onclick="changeStatus({{ $a->id }}, 'completed')">
                            Confirmed
                        </button>

                        @elseif($a->status=="completed")

                        <button
                            type="button"
                            class="btn btn-success btn-sm w-100 mb-2"
                            disabled>
                            Completed
                        </button>

                        @elseif($a->status=="cancelled")

                        <button
                            type="button"
                            class="btn btn-danger btn-sm w-100 mb-2"
                            disabled>
                            Cancelled
                        </button>

                        @endif

                        {{-- Chat --}}
                        <a href="{{ route('chat.show', $a->id) }}"
                            class="btn btn-info btn-sm w-100 mb-2">
                            <i class="bi bi-chat-dots"></i> Chat
                        </a>

                        {{-- Notes --}}
                        @if($a->status != 'completed' && $a->status != 'cancelled')
                        <button
                            id="btnNotes{{ $a->id }}"
                            class="btn {{ $a->doctor_notes ? 'btn-dark' : 'btn-secondary' }} btn-sm w-100"
                            data-id="{{ $a->id }}"
                            data-notes="{{ $a->doctor_notes }}"
                            onclick="showNotesModal(this)">
                            <i class="bi bi-journal-medical"></i>
                            {{ $a->doctor_notes ? 'Edit Notes' : 'Add Notes' }}
                        </button>
                        @else
                        <button
                            class="btn btn-success btn-sm w-100"
                            disabled>
                            <i class="bi bi-lock-fill"></i>
                            Notes Locked
                        </button>
                        @endif
                        @endif
                        <!-- admin -->
                        <!-- @if(Auth::user()->role=="admin")
                        <a href="#modalEditB" class="btn btn-sm btn-primary mb-1" data-bs-toggle="modal"
                            onclick="getEditFormB('{{ $a->id }}')">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger"
                            onclick="if(confirm('Hapus appointment ini?')) deleteDataRemove('{{ $a->id }}')">Delete</a>
                        @endif -->
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if(Auth::user()->role=="admin")
    <div class="text-center mt-4">
        <a href="{{ route('transaction.index') }}"
            class="btn btn-warning btn-lg">
            <i class="bi bi-receipt"></i>
            View Transactions
        </a>
    </div>
    @endif

</div>

<!-- Modal Doctor Notes -->
<div class="modal fade" id="modalNotes" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Doctor Notes
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <input
                    type="hidden"
                    id="notes_id">
                <div class="mb-3">
                    <label class="form-label">
                        Notes
                    </label>
                    <textarea
                        id="doctor_notes_input"
                        class="form-control"
                        rows="6"
                        placeholder="Write doctor notes here..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Cancel
                </button>
                <button
                    class="btn btn-success"
                    onclick="saveNotes()">
                    Save Notes
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    function showNotesModal(button) {
        let id = button.dataset.id;
        let notes = button.dataset.notes ?? '';

        $('#notes_id').val(id);
        $('#doctor_notes_input').val(notes);
        $('#modalNotes').modal('show');
    }

    function saveNotes() {
        var id = $('#notes_id').val();
        var doctor_notes = $('#doctor_notes_input').val();

        $.ajax({
            type: "POST",
            url: "{{ route('appointment.saveNotes') }}",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                doctor_notes: doctor_notes
            },

            success: function(response) {
                console.log(response);
                alert("Doctor notes berhasil disimpan!");
                location.reload();
            },

            error: function(xhr) {
                console.log(xhr);
                alert("ERROR");
            }
        });

    }

    function changeStatus(id, nextStatus) {

        let message = "";

        if (nextStatus == "confirmed") {

            message =
                "Appointment akan diubah menjadi CONFIRMED.\n\nLanjutkan?";

        } else if (nextStatus == "completed") {

            message =
                "Pastikan konsultasi telah selesai.\n\nUbah status menjadi COMPLETED?";

        }

        if (!confirm(message)) {
            return;
        }

        $.ajax({

            type: "POST",

            url: "{{ route('appointment.updateStatus') }}",

            data: {

                _token: "{{ csrf_token() }}",

                id: id,

                status: nextStatus

            },

            success: function(response) {

                location.reload();

            },

            error: function() {

                alert("Gagal mengubah status.");

            }

        });

    }

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