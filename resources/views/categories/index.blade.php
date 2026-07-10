@extends('layouts.adminlte4')
@section('title', 'Service Categories')
@section('sidebar-categories', 'active')

@section('breadcrumb')
<li class="breadcrumb-item active">Categories</li>
@endsection

@push('styles')
<style>
    .table-bordered td,
    .table-bordered th {
        border: 1px solid #dee2e6 !important;
        vertical-align: middle;
    }

    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }

    .btn-sm {
        padding: 5px 12px;
    }

    .modal-xl {
        max-width: 1140px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-4">Categories List</h1>

        @can('create-permission', Auth::user())
        <button type="button" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#btnFormModal">
            <i class="bi bi-plus-circle"></i>
            New Category (With Modals)
        </button>
        @endcan
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('status'))
    <div class="alert alert-warning">{{ session('status') }}</div>
    @endif

    <div id="showinfo"></div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" class="d-flex align-items-center gap-2">
            <label>Show</label>
            <select name="per_page" onchange="this.form.submit()">
                <option value="10" {{ request('per_page') == 10  ? 'selected' : '' }}>10</option>
                <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
            </select>
            entries
        </form>
        {{ $allCategories->links() }}
    </div>



    <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th class="text-center">ID</th>
                <th>Category Name</th>
                <th class="text-center">Image</th>
                <th class="text-center">Total Services</th>
                <th class="text-center">List Services</th>
                @can('update-permission', Auth::user())
                <th class="text-center">Action</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @forelse($allCategories as $cat)
            <tr id="tr_{{ $cat->id }}">
                <td class="text-center"><span class="badge bg-secondary">{{ $cat->id }}</span></td>
                <td class="fw-bold text-primary" id="td_name_{{ $cat->id }}">{{ $cat->category_name }}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#imageModal-{{ $cat->id }}">
                        <i class="fas fa-image"></i> Show Image
                    </button>
                </td>
                <td class="text-center">
                    <span class="badge bg-info rounded-pill">{{ $cat->services->count() }}</span>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                        data-bs-target="#detailModal" onclick="showDetail('{{ $cat->id }}')">
                        <i class="fas fa-list"></i> Details
                    </button>
                </td>
                @can('update-permission', Auth::user())
                <td class="text-center">
                    <a href="#modalEditB" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                        onclick="getEditFormB('{{ $cat->id }}')">Edit</a>
                    @can('delete-permission', Auth::user())
                    <a href="#" class="btn btn-sm btn-danger"
                        onclick="if(confirm('Hapus {{ $cat->category_name }}?')) deleteDataRemove('{{ $cat->id }}')">
                        Delete
                    </a>
                    @endcan
                </td>
                @endcan
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-4">No categories found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
</div>

{{-- Image Modals --}}
@foreach($allCategories as $cat)
@push('modal')
<div class="modal fade" id="imageModal-{{ $cat->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Picture for Category: {{ $cat->category_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                @php
                $imagePath = public_path('storage/categories/' . $cat->image);
                $imageFound = file_exists($imagePath);
                $imageUrl = asset('storage/categories/' . $cat->image);
                @endphp

                @if($imageFound)
                <img src="{{ $imageUrl }}" class="img-fluid rounded" style="max-height: 300px;">
                @else
                <div class="p-5 bg-light rounded">
                    <i class="fas fa-image fa-4x text-muted mb-3"></i>
                    <p class="text-muted">No image available</p>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endpush
@endforeach

{{-- Detail Modal --}}
@push('modal')
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="detail-title">Service List</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detail-body">
                <p class="text-center text-muted py-4">Click Details button to view services</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endpush

{{-- Modal Create --}}
@push('modal')
<div class="modal fade" id="btnFormModal" tabindex="-1" role="basic">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Category</h4>
            </div>
            <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name of Category</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter name of category">
                        <br>
                        <label>Image</label>
                        <input type="file" class="form-control" name="image">
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
@endpush

{{-- Modal Edit B --}}
@push('modal')
<div class="modal fade" id="modalEditB" tabindex="-1" role="basic">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Your Category</h4>
            </div>
            <div class="modal-body" id="modalContentB"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endpush

@endsection

@push('script')
<script>
    function showDetail(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("categories.showListServices") }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'idcat': id
            },
            success: function(data) {
                $('#detail-title').html(data.title);
                $('#detail-body').html(data.body);
            }
        });
    }

    function getEditFormB(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("categories.getEditFormB") }}',
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
        var name = $('#cname').val();
        console.log(name);
        $.ajax({
            type: 'POST',
            url: '{{ route("categories.saveDataUpdate") }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id,
                'name': name,
            },
            success: function(data) {
                if (data.status == "oke") {
                    $('#td_name_' + id).html(name);
                    $('#modalEditB').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                }
            }
        });
    }

    function deleteDataRemove(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("categories.deleteData") }}',
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