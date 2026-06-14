@extends('layouts.adminlte4')
@section('title', 'Doctors')
@section('sidebar-doctors', 'active')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Doctor List</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr class="text-center">
                    <th style="width: 50px;">ID</th>
                    <th style="width: 100px;">Photo</th>
                    <th>Name</th>
                    <th id="td_spec_header">Specialization</th>
                    <th>Services</th>
                    <th style="width: 100px;">Experience</th>
                    <th style="width: 100px;">STR Number</th>
                    <th style="width: 180px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($doctors as $d)
                <tr id="tr_{{ $d->id }}">
                    <td class="text-center"><span class="badge bg-secondary">{{ $d->id }}</span></td>
                    <td class="text-center" style="padding: 5px;">
                        @php
                            $avatarPath = $d->user->avatar ?? null;
                            $fullPath = $avatarPath ? public_path('storage/' . $avatarPath) : null;
                            $hasValidImage = $avatarPath && $fullPath && file_exists($fullPath);
                        @endphp
                        @if($hasValidImage)
                            <img src="{{ asset('storage/' . $avatarPath) }}" alt="{{ $d->user->name }}"
                                style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <img src="{{ asset('storage/img/profiles/default-avatar.jpg') }}" alt="Default Avatar"
                                style="width: 100px; height: 100px; object-fit: cover;">
                        @endif
                    </td>
                    <td>{{ $d->user->name }}</td>
                    <td id="td_spec_{{ $d->id }}" style="white-space: normal; word-wrap: break-word;">
                        <span class="badge bg-primary" style="font-size: 0.9rem; padding: 8px 12px;">
                            {{ $d->specialization->name }}
                        </span>
                    </td>
                    <td>
                        @if($d->services && $d->services->count() > 0)
                            @foreach($d->services as $service)
                                <span class="badge bg-secondary mb-1" style="font-size: 0.7rem; display: inline-block; margin-right: 3px;">
                                    {{ $service->service_name }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td id="td_exp_{{ $d->id }}">{{ $d->experience_years }} years</td>
                    <td id="td_str_{{ $d->id }}">{{ $d->str_number }}</td>
                    <td class="text-center">
                        <a href="#modalEditB" class="btn btn-sm btn-primary mb-1" data-bs-toggle="modal"
                           onclick="getEditFormB({{ $d->id }})">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger"
                           onclick="if(confirm('Hapus dr. {{ $d->user->name }}?')) deleteDataRemove({{ $d->id }})">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Edit B --}}
<div class="modal fade" id="modalEditB" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Doctor</h4>
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
    var experience_years = $('#edit_experience_years').val();
    var specialization_id = $('#edit_specialization_id').val();
    var str_number = $('#edit_str_number').val();

    $.ajax({
        type: 'POST',
        url: '{{ route("doctor.saveDataUpdate") }}',
        data: {
            '_token': '<?php echo csrf_token(); ?>',
            'id': id,
            'experience_years': experience_years,
            'specialization_id': specialization_id,
            'str_number': str_number
        },
        success: function(data) {
            if (data.status == "oke") {
                $('#td_exp_' + id).html(experience_years + ' years');
                $('#td_str_' + id).html(str_number);
                $('#td_spec_' + id).html('<span class="badge bg-primary" style="font-size:0.9rem;padding:8px 12px;">' + data.specialization_name + '</span>');
                $('#modalEditB').modal('hide');
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