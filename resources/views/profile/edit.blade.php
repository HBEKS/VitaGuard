<div class="modal-header">
    <h5 class="modal-title">Edit Profile</h5>

    <button type="button"
        class="btn-close"
        data-bs-dismiss="modal">
    </button>
</div>

<div class="modal-body">

    <div class="text-center mb-3">

        @if(!empty($user->avatar))
        <img src="{{ asset('storage/'.$user->avatar) }}"
            style="width:100px;height:100px;object-fit:cover;"
            class="rounded-circle border">
        @endif

    </div>

    <div class="mb-3">
        <label>Name</label>
        <input
            id="editName"
            class="form-control"
            value="{{ $user->name }}">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input
            id="editEmail"
            class="form-control"
            value="{{ $user->email }}">
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input
            id="editPhone"
            class="form-control"
            value="{{ $user->phone }}">
    </div>

    <div class="mb-3">
        <label>New Password</label>
        <input
            id="editPassword"
            type="password"
            class="form-control">
    </div>

    <!-- Password rules -->
    <div id="passwordRules" class="mb-3" style="display:none;">
        <div id="ruleLength" class="text-danger">
            <i class="bi bi-x-lg"></i> Minimal 8 karakter
        </div>
        <div id="ruleUpper" class="text-danger">
            <i class="bi bi-x-lg"></i> Mengandung huruf besar
        </div>
        <div id="ruleLower" class="text-danger">
            <i class="bi bi-x-lg"></i> Mengandung huruf kecil
        </div>
        <div id="ruleNumber" class="text-danger">
            <i class="bi bi-x-lg"></i> Mengandung angka
        </div>
    </div>

    <div class="mb-3">
        <label>Confirm Password</label>
        <input
            id="editPasswordConfirmation"
            type="password"
            class="form-control">
    </div>

    <!-- Password match message -->
    <div
        id="passwordMatch"
        class="mb-3"
        style="display:none;">
    </div>

    <div class="mb-3">
        <label>Avatar</label>
        <input
            id="editAvatar"
            type="file"
            class="form-control"
            accept="image/*">
    </div>

</div>

<div class="modal-footer">

    <button
        class="btn btn-secondary"
        data-bs-dismiss="modal">
        Cancel
    </button>

    <button
        class="btn btn-primary"
        onclick="saveProfile()">
        Save
    </button>

</div>
