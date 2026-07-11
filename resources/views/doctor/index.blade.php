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

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateSpecialization">
                + Add Specialization
            </button>
        </div>
        @endcan
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" class="d-flex align-items-center">
            <label class="me-2 mb-0">Show</label>
            <select name="per_page" class="form-select form-select-sm" style="width:80px" onchange="this.form.submit()">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25</option>
            </select>
            <span class="ms-2">entries</span>
        </form>
        {{ $doctors->withQueryString()->links() }}
    </div>

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
                    <td class="text-center">
                        @if($doctor->avatar && file_exists(public_path('storage/' . $doctor->avatar)))
                        <img src="{{ asset('storage/' . $doctor->avatar) }}" width="60" height="60"
                            class="rounded-circle" style="object-fit:cover;">
                        @else
                        <i class="bi bi-person-circle text-primary" style="font-size:50px;"></i>
                        @endif
                    </td>
                    <td>{{ $doctor->name }}</td>
                    <td>{{ $doctor->doctorProfile?->specialization?->name ?? '-' }}</td>
                    <td>
                        @forelse($doctor->doctorProfile?->services ?? [] as $service)
                        <span class="badge bg-info mb-1">{{ $service->service_name }}</span>
                        @empty
                        -
                        @endforelse
                    </td>
                    <td>{{ $doctor->doctorProfile?->experience_years ?? '-' }} Years</td>
                    <td>{{ $doctor->doctorProfile?->str_number ?? '-' }}</td>
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
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Full name" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                placeholder="Password"
                                required>
                            <div class="mt-2" id="passwordChecklist">

                                <div id="length" class="text-danger">
                                    ❌ At least 8 characters
                                </div>

                                <div id="uppercase" class="text-danger">
                                    ❌ Contains uppercase letter
                                </div>

                                <div id="lowercase" class="text-danger">
                                    ❌ Contains lowercase letter
                                </div>

                                <div id="number" class="text-danger">
                                    ❌ Contains a number
                                </div>

                                <div id="special" class="text-danger">
                                    ❌ Contains special character
                                </div>
                            </div>
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
                            <select name="service_ids[]" id="service_ids"
                                class="form-select"
                                multiple="multiple"
                                required>

                                @foreach($services as $service)
                                <option value="{{ $service->id }}">
                                    {{ $service->service_name }}
                                </option>
                                @endforeach

                            </select>

                            <small class="text-muted">
                                You can select more than one service.
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
                        <button id="btnSave" type="submit" class="btn btn-primary" disabled>
                            Save
                        </button>
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Add Specialization --}}
    <div class="modal fade" id="modalCreateSpecialization" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Add Specialization</h4>
                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="{{ route('specializations.store') }}">
                    @csrf

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Specialization Name</label>
                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Example: Cardiology"
                                required>
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="submit"
                            class="btn btn-success">
                            Save
                        </button>

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Close
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {

        $('#modalCreate').on('shown.bs.modal', function() {

            $('#service_ids').select2({
                dropdownParent: $('#modalCreate'),
                width: '100%',
                placeholder: 'Select Services'
            });

        });

    });

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
        var formData = new FormData();
        formData.append('_token', '<?php echo csrf_token(); ?>');
        formData.append('id', id);
        formData.append('name', $('#edit_name').val());
        formData.append('email', $('#edit_email').val());
        formData.append('specialization_id', $('#edit_specialization_id').val());
        formData.append('experience_years', $('#edit_experience_years').val());
        formData.append('str_number', $('#edit_str_number').val());

        var serviceIds = $('#edit_service_ids').val();
        if (serviceIds) {
            serviceIds.forEach(function(sid) {
                formData.append('service_ids[]', sid);
            });
        }

        if ($('#edit_avatar')[0].files[0]) {
            formData.append('avatar', $('#edit_avatar')[0].files[0]);
        }

        $.ajax({
            type: 'POST',
            url: '{{ route("doctor.saveDataUpdate") }}',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status == "oke") {
                    $('#modalEditB').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    location.reload();
                }
            },
            error: function(xhr) {
                alert(xhr.responseText);
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

    $('#password').on('input', function() {

        let password = $(this).val();

        let score = 0;

        let length = password.length >= 8;
        let upper = /[A-Z]/.test(password);
        let lower = /[a-z]/.test(password);
        let number = /[0-9]/.test(password);
        let special = /[^A-Za-z0-9]/.test(password);

        checkRule('#length', length);
        checkRule('#uppercase', upper);
        checkRule('#lowercase', lower);
        checkRule('#number', number);
        checkRule('#special', special);

        if (length) score++;
        if (upper) score++;
        if (lower) score++;
        if (number) score++;
        if (special) score++;

        // Enable tombol Save hanya jika semua syarat terpenuhi
        $('#btnSave').prop('disabled', score < 5);

    });


    function checkRule(element, passed) {

        if (passed) {

            $(element)
                .removeClass('text-danger')
                .addClass('text-success')
                .html('✅ ' + $(element).text().replace('❌ ', '').replace('✅ ', ''));

        } else {

            $(element)
                .removeClass('text-success')
                .addClass('text-danger')
                .html('❌ ' + $(element).text().replace('❌ ', '').replace('✅ ', ''));

        }

    }
</script>
@endpush
