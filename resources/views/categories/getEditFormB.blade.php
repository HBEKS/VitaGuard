<div class="mb-3">
    <label>Category Name</label>
    <input type="text" id="cname" class="form-control" value="{{ $data->category_name }}">
</div>
<button type="button" class="btn btn-primary" onclick="saveDataUpdate('{{ $data->id }}')">Update</button>
