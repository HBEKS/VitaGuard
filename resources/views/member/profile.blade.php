@extends('layouts.orbit')

@section('title', 'My Profile')
@section('sidebar-profile', 'active')

@section('content')

<section class="section py-5">
    <div class="container">

        {{-- Tombol Navigasi Kembali --}}
        <div class="mb-4">
            <a href="{{ route('member.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-house me-1"></i> Back to Home
            </a>
        </div>

        {{-- Kartu Profil --}}
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-primary text-white p-4">
                <h3 class="card-title mb-0 fw-bold text-white">
                    <i class="bi bi-person-badge me-2"></i>My Profile
                </h3>
            </div>

            <div class="card-body text-center p-4">
                <div class="mb-4">
                    {{-- Cek Foto Profil User --}}
                    @if(!empty($user->avatar) && file_exists(public_path('storage/' . $user->avatar)))
                    <img src="{{ asset('storage/' . $user->avatar) }}"
                        class="rounded-circle border shadow"
                        width="120"
                        height="120"
                        alt="Profile Picture"
                        style="object-fit: cover;">
                    @else
                    <i class="bi bi-person-circle text-primary" style="font-size: 100px;"></i>
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <tbody>
                            <tr>
                                <th class="bg-light" style="width: 30%;">Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Phone</th>
                                <td>{{ $user->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Role</th>
                                <td><span class="badge bg-success">{{ ucfirst($user->role) }}</span></td>
                            </tr>

                            @if($user->role == 'doctor')
                            <tr>
                                <th class="bg-light">Specialization</th>
                                <td>
                                    {{ $user->doctorProfile->specialization->name ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th class="bg-light">Services</th>
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
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary px-4 py-2 rounded-pill" onclick="getEditProfileForm()">
                        <i class="bi bi-pencil-square me-1"></i> Edit Profile
                    </button>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- Container Modal --}}
@push('modal')
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" id="editProfileContent"></div>
    </div>
</div>
@endpush

@endsection

@push('script')
<script>
    function getEditProfileForm() {
        $.ajax({
            type: 'POST',
            url: '{{ route("member.profile.edit") }}',
            data: {
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                $('#editProfileContent').html(response);

                // Tampilkan modal
                $('#editProfileModal').modal('show');

                // Aktifkan validasi password
                initPasswordValidation();
            },
            error: function(xhr) {
                alert("Gagal memuat form edit profile.");
                console.log(xhr.responseText);
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
            url: '{{ route("member.profile.update") }}',
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

        // Jika password kosong
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
            match.className = "text-success mb-3";
            match.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Password cocok';
        } else {
            match.className = "text-danger mb-3";
            match.innerHTML = '<i class="bi bi-x-circle-fill me-1"></i> Password tidak cocok';
        }
    }

    function updateRule(condition, id, text) {
        let rule = document.getElementById(id);
        if (!rule) return;

        if (condition) {
            rule.className = "text-success";
            rule.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> ' + text;
        } else {
            rule.className = "text-danger";
            rule.innerHTML = '<i class="bi bi-x-circle-fill me-1"></i> ' + text;
        }
    }
</script>
@endpush
