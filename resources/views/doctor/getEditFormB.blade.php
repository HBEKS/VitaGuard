<h5 class="mb-3">Edit Doctor: {{ $data->user->name }}</h5>

<div class="form-group mb-2">
    <label>Specialization</label>
    <select class="form-control" id="edit_specialization_id">
        @foreach($specializations as $s)
            <option value="{{ $s->id }}" {{ $data->specialization_id == $s->id ? 'selected' : '' }}>
                {{ $s->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group mb-2">
    <label>Experience Years</label>
    <input type="number" class="form-control" id="edit_experience_years" value="{{ $data->experience_years }}">
</div>

<div class="form-group mb-3">
    <label>STR Number</label>
    <input type="text" class="form-control" id="edit_str_number" value="{{ $data->str_number }}">
</div>

<button type="button" onclick="saveDataUpdate({{ $data->id }})" class="btn btn-primary">Save Changes</button>