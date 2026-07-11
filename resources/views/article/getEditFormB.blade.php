<div class="mb-3">
    @if($data->image_url)
    <img src="{{ asset('storage/' . $data->image_url) }}"
        class="img-fluid rounded mb-2" style="max-height:150px;">
    @endif
    <label>Image (kosongkan jika tidak diubah)</label>
    <input type="file" id="edit_image" class="form-control" accept="image/*">
</div>
<div class="mb-3">
    <label>Title</label>
    <input type="text" id="edit_title" class="form-control" value="{{ $data->title }}">
</div>
<div class="mb-3">
    <label>Content</label>
    <textarea id="edit_content" class="form-control" rows="4">{{ $data->content }}</textarea>
</div>
<div class="mb-3">
    <label>Status</label>
    <select id="edit_status" class="form-select">
        <option value="draft" {{ $data->status == 'draft' ? 'selected' : '' }}>Draft</option>
        <option value="published" {{ $data->status == 'published' ? 'selected' : '' }}>Published</option>
    </select>
</div>
<button type="button" class="btn btn-primary" onclick="saveDataUpdate({{ $data->id }})">Update</button>