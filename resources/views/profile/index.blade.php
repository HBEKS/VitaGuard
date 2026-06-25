@extends('layouts.adminlte4')
@section('sidebar-profile', 'active')
@section('content')

<title>Profile</title>
<style>
    .avatar {
        vertical-align: middle;
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
</style>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">My Profile</h3>
    </div>

    <div class="card-body text-center">
        <div class="mb-4">
            @if(!empty($user->avatar) && file_exists(public_path('adminlte4/assets/' . $user->avatar)))
                <img src="{{ asset('adminlte4/assets/' . $user->avatar) }}"
                    class="rounded-circle border shadow"
                    width="120"
                    height="120"
                    alt="Profile Picture"
                    style="object-fit: cover;"
                >
            @else
                <i class="bi bi-person-circle text-primary"
                style="font-size: 100px;">
                </i>
            @endif
        </div>

        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $user->phone ?? '-' }}</td>
            </tr>
            <tr>
                <th>Role</th>
                <td>{{ $user->role }}</td>
            </tr>
        </table>
        <br>
        <button class="btn btn-primary" onClick="getEditProfileForm()">
            <i class="bi bi-pencil-square"></i>
            Edit Profile
        </button>
    </div>
</div>

<!-- modal -->
 @push('modal')
 <div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" id="editProfileContent">

            

        </div>
    </div>
</div>
@endpush

@endsection

@push('script')
<script>
    function getEditProfileForm() {
                $.ajax({
                    type:'POST', 
                    url: '{{ route("profile.edit") }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        $('#editProfileContent').html(response);
                        $('#editProfileModal').modal('show');
                    }
                });
    }

    function saveProfile(){
    let formData = new FormData();

    formData.append('_token', '{{ csrf_token() }}');
    formData.append('name', $('#editName').val());
    formData.append('email', $('#editEmail').val());
    formData.append('password', $('#editPassword').val());
    formData.append('password_confirmation', $('#editPasswordConfirmation').val());

    if ($('#editAvatar')[0].files.length > 0) {
        formData.append('avatar', $('#editAvatar')[0].files[0]);
    }

    $.ajax({
        type: 'POST',
        url: '{{ route("profile.update") }}',
        data: formData,
        processData: false,
        contentType: false,

        success: function(response) {

            alert("Profile berhasil diperbarui!");

            $('#editProfileModal').modal('hide');

            location.reload();

        },

        error: function(xhr) {

            if (xhr.status == 422) {

                let errors = xhr.responseJSON.errors;

                let message = "";

                $.each(errors, function(key, value) {
                    message += "• " + value[0] + "\n";
                });

                alert(message);

            } else {

                alert("Terjadi kesalahan pada server.");

                console.log(xhr.responseText);

            }

        }

    });

}
</script>
@endpush