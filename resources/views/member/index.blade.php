@extends('layouts.adminlte4')
@section('title', 'Member List')
@section('sidebar-members', 'active')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Member List</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">

        @can('create-permission', Auth::user())
        <button type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#modalCreate">
            + Add Member
        </button>
        @endcan

        <span class="badge bg-primary fs-6">
            {{ $members->total() }} Members
        </span>

    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">

        <form method="GET" class="d-flex align-items-center">
            <label class="me-2 mb-0">Show</label>

            <select name="per_page"
                class="form-select form-select-sm"
                style="width:80px"
                onchange="this.form.submit()">

                <option value="10"
                    {{ request('per_page',10)==10?'selected':'' }}>
                    10
                </option>

                <option value="15"
                    {{ request('per_page')==15?'selected':'' }}>
                    15
                </option>

                <option value="25"
                    {{ request('per_page')==25?'selected':'' }}>
                    25
                </option>

            </select>

            <span class="ms-2">entries</span>

        </form>

        {{ $members->withQueryString()->links() }}

    </div>

    <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th class="text-center">ID</th>
                <th>Profile</th>
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
                <td class="text-center">
                    @if($m->avatar)
                    <img src="{{ asset('storage/' . $m->avatar) }}" alt="Profile Picture" class="img-thumbnail" style="width: 50px; height: 50px;">
                    @else
                    <span class="text-muted">No Image</span>
                    @endif
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

                            <div class="input-group">
                                <input type="password"
                                    name="password"
                                    id="password"
                                    class="form-control"
                                    placeholder="Password"
                                    required>

                                <button class="btn btn-outline-secondary"
                                    type="button"
                                    id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>

                            <small id="pass-length" class="text-danger d-block">
                                ✗ Minimal 8 karakter
                            </small>

                            <small id="pass-upper" class="text-danger d-block">
                                ✗ Huruf besar
                            </small>

                            <small id="pass-lower" class="text-danger d-block">
                                ✗ Huruf kecil
                            </small>

                            <small id="pass-number" class="text-danger d-block">
                                ✗ Angka
                            </small>

                            <small id="pass-symbol" class="text-danger d-block">
                                ✗ Simbol
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                            class="btn btn-primary"
                            id="saveMember"
                            disabled>
                            Save
                        </button>
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
            url: '{{ route("members.saveDataUpdate") }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id,
                'name': $('#edit_name').val(),
                'email': $('#edit_email').val(),
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
    const password = document.getElementById('password');
    const saveBtn = document.getElementById('saveMember');

    password.addEventListener('keyup', function() {

        let value = password.value;

        let length = value.length >= 8;
        let upper = /[A-Z]/.test(value);
        let lower = /[a-z]/.test(value);
        let number = /[0-9]/.test(value);
        let symbol = /[^A-Za-z0-9]/.test(value);

        updateRule("pass-length", length);
        updateRule("pass-upper", upper);
        updateRule("pass-lower", lower);
        updateRule("pass-number", number);
        updateRule("pass-symbol", symbol);

        saveBtn.disabled = !(length && upper && lower && number && symbol);
    });

    function updateRule(id, valid) {

        let el = document.getElementById(id);

        if (valid) {
            el.classList.remove('text-danger');
            el.classList.add('text-success');
            el.innerHTML = "✔ " + el.innerHTML.substring(2);
        } else {
            el.classList.remove('text-success');
            el.classList.add('text-danger');
            el.innerHTML = "✖ " + el.innerHTML.substring(2);
        }

    }

    document.getElementById('togglePassword').addEventListener('click', function() {

        if (password.type == "password") {
            password.type = "text";
            this.innerHTML = '<i class="bi bi-eye-slash"></i>';
        } else {
            password.type = "password";
            this.innerHTML = '<i class="bi bi-eye"></i>';
        }

    });
</script>
@endpush