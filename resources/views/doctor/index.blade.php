@extends('layouts.adminlte4')
@section('title', 'Doctor List')
@section('sidebar-doctors', 'active')
@section('breadcrumb')
<li class="breadcrumb-item active">Doctors</li>
@endsection

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Doctor List</h1>
        <span class="badge bg-primary fs-6">
            {{ $doctors->total() }} Doctors
        </span>


        @can('create-permission', Auth::user())
        <div class="mt-3 mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">
                + Add Doctor
            </button>
        </div>
        @endcan
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" class="d-flex align-items-center">
            <label class="me-2 mb-0">Show</label>
            <select name="per_page" class="form-select form-select-sm" style="width:80px" onchange="this.form.submit()">
                <option value="5" {{ request('per_page', 5) == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
            </select>
            <span class="ms-2">entries</span>
        </form>
        {{ $doctors->withQueryString()->links() }}
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="text-center">Photo</th>
                    <th>Name</th>
                    <th>Specialization</th>
                    <th>Services</th>
                    <th>Experience</th>
                    <th>STR Number</th>
                    @can('update-permission', Auth::user())
                    <th class="text-center">Action</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @forelse($doctors as $doctor)
                <tr id="tr_{{ $doctor->id }}">
                    {{-- Avatar --}}
                    <td class="text-center">
                        @if($doctor->avatar && file_exists(public_path('adminlte4/assets/' . $doctor->avatar)))
                        <img src="{{ asset('adminlte4/assets/' . $doctor->avatar) }}" width="60" height="60"
                            class="rounded-circle" style="object-fit:cover;">
                        @else
                        <i class="bi bi-person-circle text-primary" style="font-size:50px;"></i>
                        @endif
                    </td>
                    {{-- Name --}}
                    <td>{{ $doctor->name }}</td>
                    {{-- Specialization --}}
                    <td>{{ $doctor->doctorProfile?->specialization?->name ?? '-' }}</td>
                    {{-- Services --}}
                    <td>
                        @forelse($doctor->doctorProfile?->services ?? [] as $service)
                        <span class="badge bg-info mb-1">{{ $service->service_name }}</span>
                        @empty
                        -
                        @endforelse
                    </td>
                    {{-- Experience --}}
                    <td>{{ $doctor->doctorProfile?->experience_years ?? '-' }} Years</td>
                    {{-- STR --}}
                    <td>{{ $doctor->doctorProfile?->str_number ?? '-' }}</td>
                    {{-- Action --}}
                    @can('update-permission', Auth::user())
                    <td class="text-center">
                        <a href="#modalEditB" class="btn btn-warning btn-sm me-1" data-bs-toggle="modal"
                            onclick="getEditFormB('{{ $doctor->id }}')">Edit</a>
                        @can('delete-permission', Auth::user())
                        <a href="#" class="btn btn-danger btn-sm"
                            onclick="if(confirm('Hapus Dr. {{ $doctor->name }}?')) deleteDataRemove('{{ $doctor->id }}')">
                            Delete
                        </a>
                        @endcan
                    </td>
                    @endcan
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No doctors found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Edit B --}}
    <div class="modal fade" id="modalEditB" tabindex="-1" role="basic">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Doctor</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalContentB"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modal Create --}}
<div class="modal fade" id="modalCreate" tabindex="-1" role="basic">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Doctor</h4>
            </div>
            <form method="POST" action="{{ route('listDoctor.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Select Member</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">-- Select Member --</option>
                            @foreach($members as $m)
                            <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Specialization</label>
                        <select name="specialization_id" class="form-select" required>
                            <option value="">-- Select Specialization --</option>
                            @foreach($specializations as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Services</label>

                        <select name="service_ids[]" class="form-select" multiple required>
                            @foreach($services as $service)
                            <option value="{{ $service->id }}">
                                {{ $service->service_name }}
                            </option>
                            @endforeach
                        </select>

                        <small class="text-muted">
                            Hold Ctrl untuk memilih lebih dari satu service.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label>Experience (years)</label>
                        <input type="number" name="experience_years" class="form-control" placeholder="0" required>
                    </div>
                    <div class="mb-3">
                        <label>STR Number</label>
                        <input type="text" name="str_number" class="form-control" placeholder="STR Number">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    function getEditFormB(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("doctor.getEditFormB") }}',
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
        $.ajax({
            type: 'POST',
            url: '{{ route("doctor.saveDataUpdate") }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id,
                'specialization_id': $('#edit_specialization_id').val(),
                'experience_years': $('#edit_experience_years').val(),
                'str_number': $('#edit_str_number').val(),
                'service_ids': $('#edit_service_ids').val(),
            },
            success: function(data) {
                if (data.status == "oke") {
                    $('#modalEditB').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    location.reload();
                }
            }
        });
    }

    function deleteDataRemove(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("doctor.deleteData") }}',
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