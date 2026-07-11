<div class="mb-3">
    @if($data->image)
    <img src="{{ asset('storage/' . $data->image) }}"
        style="width:100px;height:100px;object-fit:cover;"
        class="rounded border">
    @endif
</div>
<div class="mb-3">
    <label>Image (kosongkan jika tidak diubah)</label>
    <input type="file" id="edit_image" class="form-control" accept="image/*">
</div>
<div class="mb-3">
    <label>Category Name</label>
    <input type="text" id="cname" class="form-control" value="{{ $data->category_name }}">
</div>
<button type="button" class="btn btn-primary" onclick="saveDataUpdate('{{ $data->id }}')">Update</button>