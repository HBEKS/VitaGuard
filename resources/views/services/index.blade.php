@extends('layouts.adminlte4')
@section('title', 'Service List')
@section('sidebar-services', 'active')
@section('breadcrumb')
<li class="breadcrumb-item active">Services</li>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Services List</h1>

        @can('create-permission', Auth::user())
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#btnFormModal">
            <i class="bi bi-plus-circle"></i>
            New Service
        </button>
        @endcan
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" class="d-flex align-items-center">
            <label>Show</label>
            <select name="per_page" onchange="this.form.submit()">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
            </select>
            entries
        </form>
        {{ $services->links() }}
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="text-center" width="5%">ID</th>
                    <th class="text-center" width="15%">Service Name</th>
                    <th class="text-center" width="15%">Description</th>
                    <th class="text-center" width="15%">Availability</th>
                    <th class="text-center" width="12%">Price</th>
                    <th class="text-center" width="10%">Category Name</th>
                    @can('update-permission', Auth::user())
                    <th class="text-center" width="10%">Action</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach($services as $item)
                <tr id="tr_{{ $item->id }}">
                    <td class="text-center">
                        <span class="badge bg-secondary">{{ $item->id }}</span>
                    </td>
                    <td>{{ $item->service_name }}</td>
                    <td style="white-space: normal;">{{ $item->description }}</td>
                    <td>{{ $item->availability }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->category->category_name }}</td>
                    @can('update-permission', Auth::user())
                    <td class="text-center">
                        <a href="#modalEditB" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            onclick="getEditFormB('{{ $item->id }}')">Edit</a>
                        @can('delete-permission', Auth::user())
                        <a href="#" class="btn btn-sm btn-danger"
                            onclick="if(confirm('Hapus {{ $item->service_name }}?')) deleteDataRemove('{{ $item->id }}')">
                            Delete
                        </a>
                        @endcan
                    </td>
                    @endcan
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>





{{-- Modal Create --}}
<div class="modal fade" id="btnFormModal" tabindex="-1" role="basic">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Service</h4>
            </div>
            <form method="POST" action="{{ route('services.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Service Name</label>
                        <input type="text" name="service_name" class="form-control" placeholder="Service name">
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Availability</label>
                        <input type="text" name="availability" class="form-control"
                            placeholder="e.g. 08.00 - 17.00">
                    </div>
                    <div class="mb-3">
                        <label>Price</label>
                        <input type="number" name="price" class="form-control" placeholder="0">
                    </div>
                    <div class="mb-3">
                        <label>Category</label>
                        <select name="category_id" class="form-select">
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit B --}}
<div class="modal fade" id="modalEditB" tabindex="-1" role="basic">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Service</h4>
            </div>
            <div class="modal-body" id="modalContentB"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>
@endsection

@push('script')
<script>
    function getEditFormB(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("services.getEditFormB") }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id
            },
            success: function(data) {
                $('#modalContentB').html(data.msg);
            }
        });
    }

    function saveDataUpdate(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("services.saveDataUpdate") }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id,
                'service_name': $('#edit_service_name').val(),
                'description': $('#edit_description').val(),
                'availability': $('#edit_availability').val(),
                'price': $('#edit_price').val(),
                'category_id': $('#edit_category_id').val(),
            },
            success: function(data) {
                if (data.status == "oke") {
                    $('#modalEditB').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    location.reload();
                }
            }
        });
    }

    function deleteDataRemove(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("services.deleteData") }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id
            },
            success: function(data) {
                if (data.status == "oke") {
                    $('#tr_' + id).remove();
                }
            }
        });
    }
</script>
@endpush