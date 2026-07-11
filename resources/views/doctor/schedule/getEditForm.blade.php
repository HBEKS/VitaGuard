<div class="form-group mb-3">
    <label>Day</label>
    <select class="form-select" id="day_of_week">
        <option value="Monday" {{ $schedule->day_of_week=='Monday'?'selected':'' }}>Monday</option>
        <option value="Tuesday" {{ $schedule->day_of_week=='Tuesday'?'selected':'' }}>Tuesday</option>
        <option value="Wednesday" {{ $schedule->day_of_week=='Wednesday'?'selected':'' }}>Wednesday</option>
        <option value="Thursday" {{ $schedule->day_of_week=='Thursday'?'selected':'' }}>Thursday</option>
        <option value="Friday" {{ $schedule->day_of_week=='Friday'?'selected':'' }}>Friday</option>
        <option value="Saturday" {{ $schedule->day_of_week=='Saturday'?'selected':'' }}>Saturday</option>
        <option value="Sunday" {{ $schedule->day_of_week=='Sunday'?'selected':'' }}>Sunday</option>
    </select>

</div>

<div class="form-group mb-3">
    <label>Start Time</label>
    <input type="time"
        id="start_time"
        class="form-control"
        value="{{ $schedule->start_time }}">
</div>
<div class="form-group mb-3">
    <label>End Time</label>
    <input type="time"
        id="end_time"
        class="form-control"
        value="{{ $schedule->end_time }}">
</div>
<div class="form-check mb-3">
    <input class="form-check-input"
        type="checkbox"
        id="is_active"
        {{ $schedule->is_active ? 'checked' : '' }}>
    <label class="form-check-label">
        Active
    </label>
</div>
<button
    class="btn btn-primary"
    onclick="saveDataUpdate('{{ $schedule->id }}')">
    Save
</button>