@extends('layouts.adminlte4')

@section('title','My Schedule')
@section('sidebar-schedule','active')

@section('breadcrumb')
<li class="breadcrumb-item active">My Schedule</li>
@endsection

@push('styles')
<style>
    .table-bordered td,
    .table-bordered th {
        border: 1px solid #dee2e6 !important;
        vertical-align: middle;
    }

    .table thead th {
        background: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }

    .btn-sm {
        padding: 5px 12px;
    }
</style>
@endpush

@section('content')

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-4">My Schedule</h1>

        <button class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#btnFormModal">
            <i class="bi bi-plus-circle"></i> New Schedule
        </button>
    </div>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div id="showinfo"></div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" class="d-flex align-items-center gap-2">
            <label>Show</label>
            <select name="per_page" onchange="this.form.submit()">
                <option value="10" {{ request('per_page',10)==10?'selected':'' }}>10</option>
                <option value="15" {{ request('per_page')==15?'selected':'' }}>15</option>
                <option value="20" {{ request('per_page')==20?'selected':'' }}>20</option>
            </select>
            entries
        </form>
        {{ $allSchedules->links() }}
    </div>

    <table class="table table-bordered table-striped table-hover align-middle">

        <thead class="table-light">
            <tr>
                <th class="text-center">ID</th>
                <th>Day</th>
                <th class="text-center">Start Time</th>
                <th class="text-center">End Time</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>

        <tbody>

            @forelse($allSchedules as $schedule)

            <tr id="tr_{{ $schedule->id }}">

                <td class="text-center"><span class="badge bg-secondary">{{ $schedule->id }}</span></td>

                <td id="td_day_{{ $schedule->id }}">
                    {{ $schedule->day_of_week }}
                </td>

                <td class="text-center" id="td_start_{{ $schedule->id }}">
                    {{ substr($schedule->start_time,0,5) }}
                </td>

                <td class="text-center" id="td_end_{{ $schedule->id }}">
                    {{ substr($schedule->end_time,0,5) }}
                </td>

                <td class="text-center" id="td_status_{{ $schedule->id }}">
                    @if($schedule->is_active)
                    <span class="badge bg-success">Active</span>
                    @else
                    <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>

                <td class="text-center">
                    <a href="#modalEditB" class="btn btn-warning btn-sm" data-bs-toggle="modal" onclick="getEditFormB('{{ $schedule->id }}')">Edit</a>

                    <a href="#" class="btn btn-danger btn-sm" onclick="if(confirm('Delete this schedule?')) deleteData('{{ $schedule->id }}')">Delete</a>
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="6" class="text-center text-muted py-4">No schedules available.</td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>

{{-- Modal Create --}}
@push('modal')
<div class="modal fade" id="btnFormModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Add Schedule</h4>
            </div>

            <form method="POST" action="{{ route('doctor.schedule.store') }}">
                @csrf

                <div class="modal-body">

                    <div class="form-group mb-3">
                        <label>Day</label>
                        <select class="form-select" name="day_of_week">
                            <option>Monday</option>
                            <option>Tuesday</option>
                            <option>Wednesday</option>
                            <option>Thursday</option>
                            <option>Friday</option>
                            <option>Saturday</option>
                            <option>Sunday</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Start Time</label>
                        <input type="time" class="form-control" name="start_time">
                    </div>

                    <div class="form-group mb-3">
                        <label>End Time</label>
                        <input type="time" class="form-control" name="end_time">
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="is_active" value="1" checked>
                        <label class="form-check-label">Active</label>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endpush

{{-- Modal Edit --}}
@push('modal')
<div class="modal fade" id="modalEditB" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Schedule</h4>
            </div>
            <div class="modal-body" id="modalContentB"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
@endpush

@push('script')
<script>
    function saveDataUpdate(id) {

        var day_of_week = $('#day_of_week').val();
        var start_time = $('#start_time').val();
        var end_time = $('#end_time').val();
        var is_active = $('#is_active').is(':checked') ? 1 : 0;

        $.ajax({
            type: 'POST',
            url: '{{ route("doctor.schedule.saveDataUpdate") }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id,
                'day_of_week': day_of_week,
                'start_time': start_time,
                'end_time': end_time,
                'is_active': is_active
            },
            success: function(data) {

                if (data.status == "oke") {

                    $('#td_day_' + id).html(day_of_week);
                    $('#td_start_' + id).html(start_time.substring(0, 5));
                    $('#td_end_' + id).html(end_time.substring(0, 5));

                    if (is_active == 1) {
                        $('#td_status_' + id).html('<span class="badge bg-success">Active</span>');
                    } else {
                        $('#td_status_' + id).html('<span class="badge bg-danger">Inactive</span>');
                    }

                    $('#modalEditB').modal('hide');
                }

            }
        });
    }

    function getEditFormB(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("doctor.schedule.getEditFormB") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'id': id
            },
            success: function(data) {
                $('#modalContentB').html(data.msg);
            }
        });
    }

    function deleteData(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("doctor.schedule.deleteData") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'id': id
            },
            success: function(data) {
                $('#tr_' + id).remove();
            }
        });
    }
</script>
@endpush

@endsection