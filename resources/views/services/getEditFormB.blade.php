<div class="mb-3">
    <label>Service Name</label>
    <input type="text" id="edit_service_name" class="form-control" value="{{ $data->service_name }}">
</div>
<div class="mb-3">
    <label>Description</label>
    <textarea id="edit_description" class="form-control">{{ $data->description }}</textarea>
</div>
<div class="mb-3">
    <label>Availability</label>
    <input type="text" id="edit_availability" class="form-control" value="{{ $data->availability }}">
</div>
<div class="mb-3">
    <label>Price</label>
    <input type="number" id="edit_price" class="form-control" value="{{ $data->price }}">
</div>
<div class="mb-3">
    <label>Category</label>
    <select id="edit_category_id" class="form-select">
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ $data->category_id == $cat->id ? 'selected' : '' }}>
                {{ $cat->category_name }}
            </option>
        @endforeach
    </select>
</div>
<button type="button" class="btn btn-primary" onclick="saveDataUpdate({{ $data->id }})">Update</button>