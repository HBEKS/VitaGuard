@extends('layouts.adminlte4')
@section('title', 'Profile')
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
            {{-- CEK APAKAH USER PUNYA AVATAR DAN FILE TERSEBUT ADA DI STORAGE --}}
            @if(!empty($user->avatar) && file_exists(public_path('storage/' . $user->avatar)))
                <img src="{{ asset('storage/' . $user->avatar) }}"
                     class="rounded-circle border shadow"
                     width="120"
                     height="120"
                     alt="Profile Picture"
                     style="object-fit: cover;">
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

            @if($user->role == 'doctor')
            <tr>
                <th>Specialization</th>
                <td>
                    {{ $user->doctorProfile->specialization->name ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Services</th>
                <td>
                    @forelse($user->doctorProfile->services as $service)
                    <span class="badge bg-primary me-1 mb-1">
                        {{ $service->service_name }}
                    </span>
                    @empty
                    -
                    @endforelse
                </td>
            </tr>
            @endif
        </table>
        <br>

        <button class="btn btn-primary" onClick="getEditProfileForm()">
            <i class="bi bi-pencil-square"></i>
            Edit Profile
        </button>
    </div>
</div>

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
            type: 'POST',
            url: '{{ route("profile.edit") }}',
            data: {
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {

                $('#editProfileContent').html(response);

                // tampilkan modal
                $('#editProfileModal').modal('show');

                // aktifkan validasi password
                initPasswordValidation();
            }
        });
    }

    function saveProfile() {

        let formData = new FormData();

        formData.append('_token', '{{ csrf_token() }}');
        formData.append('name', $('#editName').val());
        formData.append('email', $('#editEmail').val());
        formData.append('phone', $('#editPhone').val());
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

    function initPasswordValidation() {

        const password = document.getElementById("editPassword");
        const confirmPassword = document.getElementById("editPasswordConfirmation");

        if (!password || !confirmPassword) return;
        password.addEventListener("keyup", validatePassword);
        confirmPassword.addEventListener("keyup", validatePassword);

    }

    function validatePassword() {

        const password = document.getElementById("editPassword");
        const confirmPassword = document.getElementById("editPasswordConfirmation");

        const value = password.value;

        // password kosong
        if (value === "") {
            document.getElementById("passwordRules").style.display = "none";
            document.getElementById("passwordMatch").style.display = "none";
            return;
        }

        document.getElementById("passwordRules").style.display = "block";

        updateRule(value.length >= 8, "ruleLength", "Minimal 8 karakter");
        updateRule(/[A-Z]/.test(value), "ruleUpper", "Mengandung huruf besar");
        updateRule(/[a-z]/.test(value), "ruleLower", "Mengandung huruf kecil");
        updateRule(/[0-9]/.test(value), "ruleNumber", "Mengandung angka");

        let match = document.getElementById("passwordMatch");

        if (confirmPassword.value === "") {
            match.style.display = "none";
            return;
        }

        match.style.display = "block";

        if (value === confirmPassword.value) {
            match.className = "text-success";
            match.innerHTML =
                '<i class="bi bi-check-circle-fill"></i> Password cocok';
        } else {

            match.className = "text-danger";
            match.innerHTML =
                '<i class="bi bi-x-circle-fill"></i> Password tidak cocok';
        }

    }

    function updateRule(condition, id, text) {

        let rule = document.getElementById(id);

        if (condition) {

            rule.className = "text-success";
            rule.innerHTML =
                '<i class="bi bi-check-circle-fill"></i> ' + text;

        } else {

            rule.className = "text-danger";
            rule.innerHTML =
                '<i class="bi bi-x-circle-fill"></i> ' + text;

        }

    }
</script>
@endpush
