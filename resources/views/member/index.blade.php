@extends('layouts.adminlte4')
@section('title', 'Member List')
@section('sidebar-members', 'active')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Member List</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @can('create-permission', Auth::user())
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCreate">
        + Add Member
    </button>
    @endcan

    <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th class="text-center">ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                @can('update-permission', Auth::user())
                <th class="text-center">Action</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @forelse($members as $m)
            <tr id="tr_{{ $m->id }}">
                <td class="text-center"><span class="badge bg-secondary">{{ $m->id }}</span></td>
                <td id="td_name_{{ $m->id }}">{{ $m->name }}</td>
                <td>{{ $m->email }}</td>
                <td>{{ $m->phone ?? '-' }}</td>
                @can('update-permission', Auth::user())
                <td class="text-center">
                    <a href="#modalEditB" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal"
                       onclick="getEditFormB('{{ $m->id }}')">Edit</a>
                    @can('delete-permission', Auth::user())
                    <a href="#" class="btn btn-sm btn-danger"
                       onclick="if(confirm('Hapus {{ $m->name }}?')) deleteDataRemove('{{ $m->id }}')">Delete</a>
                    @endcan
                </td>
                @endcan
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No members found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Modal Create --}}
    <div class="modal fade" id="modalCreate" tabindex="-1" role="basic">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Member</h4>
                </div>
                <form method="POST" action="{{ route('members.store') }}">
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
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
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

    {{-- Modal Edit B --}}
    <div class="modal fade" id="modalEditB" tabindex="-1" role="basic">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Member</h4>
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
@endsection

@push('script')
<script>
function getEditFormB(id) {
    $.ajax({
        type: 'POST',
        url: '{{ route("members.getEditFormB") }}',
        data: { '_token': '<?php echo csrf_token(); ?>', 'id': id },
        success: function(data) {
            $('#modalContentB').html(data.msg);
        }
    });
}

function saveDataUpdate(id) {
    $.ajax({
        type: 'POST',
        url: '{{ route("members.saveDataUpdate") }}',
        data: {
            '_token'  : '<?php echo csrf_token(); ?>',
            'id'      : id,
            'name'    : $('#edit_name').val(),
            'email'   : $('#edit_email').val(),
            'password': $('#edit_password').val(),
        },
        success: function(data) {
            if (data.status == "oke") {
                $('#td_name_' + id).html($('#edit_name').val());
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
        url: '{{ route("members.deleteData") }}',
        data: { '_token': '<?php echo csrf_token(); ?>', 'id': id },
        success: function(data) {
            if (data.status == "oke") {
                $('#tr_' + id).remove();
            }
        }
    });
}
</script>
@endpush