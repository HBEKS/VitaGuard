<div class="mb-3">
    <label>Name</label>
    <input type="text" id="edit_name" class="form-control" value="{{ $data->name }}">
</div>
<div class="mb-3">
    <label>Email</label>
    <input type="email" id="edit_email" class="form-control" value="{{ $data->email }}">
</div>
<div class="mb-3">
    <label>Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
    <input type="password" id="edit_password" class="form-control">
</div>
<button type="button" class="btn btn-primary" onclick="saveDataUpdate({{ $data->id }})">Update</button>