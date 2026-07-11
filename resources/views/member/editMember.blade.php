<div class="modal-header">
    <h5 class="modal-title fw-bold">Edit Profile</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

    {{-- Avatar Preview --}}
    <div class="text-center mb-4">
        @if(!empty($user->avatar) && file_exists(public_path('storage/' . $user->avatar)))
            <img src="{{ asset('storage/' . $user->avatar) }}"
                 style="width:100px; height:100px; object-fit:cover;"
                 class="rounded-circle border shadow-sm"
                 alt="Profile Picture">
        @else
            <i class="bi bi-person-circle text-primary" style="font-size: 80px;"></i>
        @endif
    </div>

    {{-- Name --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Name</label>
        <input id="editName" type="text" class="form-control" value="{{ $user->name }}">
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Email</label>
        <input id="editEmail" type="email" class="form-control" value="{{ $user->email }}">
    </div>

    {{-- Phone --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Phone</label>
        <input id="editPhone" type="text" class="form-control" value="{{ $user->phone }}">
    </div>

    <hr class="my-4">

    {{-- Password Fields --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">New Password <span class="text-muted fw-normal fs-7">(Kosongkan jika tidak ingin mengubah)</span></label>
        <input id="editPassword" type="password" class="form-control" autocomplete="new-password">
    </div>

    {{-- Password Rules Realtime --}}
    <div id="passwordRules" class="mb-3 p-3 bg-light rounded-3" style="display:none;">
        <small class="d-block fw-bold mb-2">Syarat Password:</small>
        <div id="ruleLength" class="text-danger small mb-1"><i class="bi bi-x-circle-fill me-1"></i> Minimal 8 karakter</div>
        <div id="ruleUpper" class="text-danger small mb-1"><i class="bi bi-x-circle-fill me-1"></i> Mengandung huruf besar</div>
        <div id="ruleLower" class="text-danger small mb-1"><i class="bi bi-x-circle-fill me-1"></i> Mengandung huruf kecil</div>
        <div id="ruleNumber" class="text-danger small"><i class="bi bi-x-circle-fill me-1"></i> Mengandung angka</div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Confirm Password</label>
        <input id="editPasswordConfirmation" type="password" class="form-control" autocomplete="new-password">
    </div>

    <div id="passwordMatch" class="mb-3 fw-semibold small" style="display:none;"></div>

    <hr class="my-4">

    {{-- Avatar Upload --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Upload New Avatar</label>
        <input id="editAvatar" type="file" class="form-control" accept="image/*">
    </div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-primary rounded-pill px-4" onclick="saveProfile()">Save Changes</button>
</div>
