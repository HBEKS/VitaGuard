@extends('layouts.adminlte4')
@section('title', 'Appointments')
@section('sidebar-booking', 'active')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Appointments</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Doctor</th>
                    <th>Patient</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $a)
                <tr id="tr_{{ $a->id }}">
                    <td class="text-center"><span class="badge bg-secondary">{{ $a->id }}</span></td>
                    <td>{{ $a->doctor->name ?? '-' }}</td>
                    <td>{{ $a->member->name ?? '-' }}</td>
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
                    <td id="td_date_{{ $a->id }}">{{ $a->appointment_date->format('Y-m-d') }}</td>
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
                    <td class="text-center">
                        <a href="#modalEditB" class="btn btn-sm btn-primary mb-1" data-bs-toggle="modal"
                           onclick="getEditFormB('{{ $a->id }}')">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger"
                           onclick="if(confirm('Hapus appointment ini?')) deleteDataRemove('{{ $a->id }}')">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <hr class="my-4">
    <div class="d-flex gap-3 justify-content-center">
        <a href="{{ url('dashboard/transaction') }}" class="btn btn-warning">View Transactions</a>
        <a href="{{ url('/') }}" class="btn btn-outline-dark">Back to Home</a>
    </div>
</div>

{{-- Modal Edit B --}}
<div class="modal fade" id="modalEditB" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Appointment</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContentB">
                <div class="text-center py-3">Loading...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
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