<div class="mb-3">
    <label>Specialization</label>
    <select id="edit_specialization_id" class="form-select">
        @foreach($specializations as $s)
            <option value="{{ $s->id }}" {{ $doctor->doctorProfile?->specialization_id == $s->id ? 'selected' : '' }}>
                {{ $s->name }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label>Experience (years)</label>
    <input type="number" id="edit_experience_years" class="form-control"
        value="{{ $doctor->doctorProfile?->experience_years }}">
</div>
<div class="mb-3">
    <label>STR Number</label>
    <input type="text" id="edit_str_number" class="form-control"
        value="{{ $doctor->doctorProfile?->str_number }}">
</div>
<div class="mb-3">
    <label>Services <small class="text-muted">(Ctrl/Cmd untuk multi-select)</small></label>
    <select id="edit_service_ids" class="form-select" multiple style="height: 150px;">
        @foreach($services as $s)
            @php $selected = false; @endphp
            @foreach($doctor->doctorProfile?->services ?? [] as $ds)
                @if($ds->id == $s->id)
                    @php $selected = true; @endphp
                @endif
            @endforeach
            <option value="{{ $s->id }}" {{ $selected ? 'selected' : '' }}>
                {{ $s->service_name }}
            </option>
        @endforeach
    </select>
</div>
<button type="button" class="btn btn-primary" onclick="saveDataUpdate({{ $doctor->id }})">Update</button>