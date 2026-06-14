<h5 class="mb-3">Edit Appointment</h5>

<div class="form-group mb-2">
    <label>Patient</label>
    <input type="text" class="form-control" value="{{ $data->member->name ?? '-' }}" disabled>
</div>

<div class="form-group mb-2">
    <label>Doctor</label>
    <input type="text" class="form-control" value="{{ $data->doctor->name ?? '-' }}" disabled>
</div>

<div class="form-group mb-2">
    <label>Appointment Date</label>
    <input type="date" class="form-control" id="edit_appointment_date"
           value="{{ $data->appointment_date->format('Y-m-d') }}">
</div>

<div class="form-group mb-2">
    <label>Status</label>
    <select class="form-control" id="edit_status">
        @foreach($statuses as $s)
            <option value="{{ $s }}" {{ $data->status == $s ? 'selected' : '' }}>
                {{ ucfirst($s) }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group mb-3">
    <label>Doctor Notes</label>
    <textarea class="form-control" id="edit_doctor_notes" rows="3">{{ $data->doctor_notes }}</textarea>
</div>

<button type="button" onclick="saveDataUpdate('{{ $data->id }}')" class="btn btn-primary">Save Changes</button>