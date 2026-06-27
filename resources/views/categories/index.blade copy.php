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
<script>
    function showDetail(id) {
        $('#detail-title').html('Loading...');
        $('#detail-body').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin fa-2x"></i> Loading...</div>');
        $('#detailModal').modal('show');

        $.ajax({
            type: 'POST',
            url: '{{ route("categories.showListServices") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'idcat': id
            },
            dataType: 'json',
            success: function(data) {
                if (data.status == 'oke') {
                    $('#detail-title').html(data.title);
                    $('#detail-body').html(data.body);
                } else {
                    $('#detail-title').html('Error');
                    $('#detail-body').html('<div class="alert alert-danger">' + (data.body || 'Terjadi kesalahan') + '</div>');
                }
            },
            error: function(xhr, status, error) {
                $('#detail-title').html('Error');
                $('#detail-body').html('<p class="text-danger">Gagal memuat data layanan</p>');
            }
        });
    }
</script>

<div class="container mt-4">
    <div class="container-table">
        <h1 class="mb-4">Categories List</h1>

        <div class="table-responsive">
            <div id="showinfo"></div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form method="GET" class="d-flex align-items-center">
                    <label>Show</label>
                    <select name="per_page" onchange="this.form.submit()">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 15 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 25 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 50 ? 'selected' : '' }}>100</option>
                    </select>
                    entries
                </form>
                {{ $allCategories->links() }}
            </div>

            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-center" style="width: 60px;">ID</th>
                        <th scope="col" style="width: 250px;">Category Name</th>
                        <th scope="col" class="text-center" style="width: 150px;">Image</th>
                        <th scope="col" class="text-center" style="width: 130px;">Total Services</th>
                        <th scope="col" class="text-center" style="width: 100px;">List Services</th>
                        @can('update-permission', Auth::user())
                        <th scope="col" class="text-center" style="width: 150px;">Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse($allCategories as $cat)
                    <tr id="tr_{{ $cat->id }}">
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $cat->id }}</span>
                        </td>
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
                            <button type="button" class="btn btn-info btn-sm" onclick="showDetail('{{ $cat->id }}')">
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
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                            No categories found. Please run seeder.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <hr class="my-4">

        @can('create-permission', Auth::user())
        <div class="d-flex gap-3 justify-content-center">
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#btnFormModal">
                + New Category (With Modals)
            </button>
            <a href="{{ url('dashboard/services') }}" class="btn btn-warning">
                <i class="fas fa-stethoscope"></i> View Services
            </a>
            <a href="{{ url('/') }}" class="btn btn-outline-dark">
                <i class="fas fa-home"></i> Back to Home
            </a>
        </div>
        @endcan
    </div>

    {{-- Image Modals --}}
    @foreach($allCategories as $cat)
    <div class="modal fade" id="imageModal-{{ $cat->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-image me-2"></i> Picture for Category: {{ $cat->category_name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    @php
                        $imageFound = false;
                        $imageUrl = null;
                        $possiblePaths = [
                            $cat->image,
                            'img/categories/' . $cat->id . '.jpg',
                            'img/categories/' . $cat->id . '.png',
                            'img/categories/' . \Illuminate\Support\Str::slug($cat->category_name) . '.jpg',
                            'img/categories/' . \Illuminate\Support\Str::slug($cat->category_name) . '.png',
                        ];
                        foreach ($possiblePaths as $path) {
                            if ($path && file_exists(public_path('storage/' . $path))) {
                                $imageFound = true;
                                $imageUrl = asset('storage/' . $path);
                                break;
                            }
                        }
                    @endphp
                    @if($imageFound)
                        <img src="{{ $imageUrl }}" alt="{{ $cat->category_name }}"
                            class="img-fluid rounded" style="max-height: 300px;">
                    @else
                        <div class="p-5 bg-light rounded">
                            <i class="fas fa-image fa-4x text-muted mb-3"></i>
                            <h5>{{ $cat->category_name }}</h5>
                            <p class="text-muted">No image available for this category</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- Detail Modal --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="detail-title">
                        <i class="fas fa-list me-2"></i> Service List
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detail-body">
                    <p class="text-center text-muted py-4">
                        <i class="fas fa-info-circle fa-2x mb-2 d-block"></i>
                        Click Details button to view services
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Create --}}
    <div class="modal fade" id="btnFormModal" tabindex="-1" role="basic">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Category</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name of Category</label>
                        <input type="text" id="create_name" class="form-control" placeholder="Enter name of category">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="storeData()">Submit</button>
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit B --}}
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

</div>
@endsection

@push('script')
<script>
function storeData() {
    $.ajax({
        type: 'POST',
        url: '{{ route("categories.storeData") }}',
        data: {
            '_token': '<?php echo csrf_token(); ?>',
            'category_name': $('#create_name').val(),
            'image': '',
        },
        success: function(data) {
            if (data.status == "oke") {
                $('#btnFormModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                location.reload();
            }
        }
    });
}

function getEditFormB(id) {
    $.ajax({
        type: 'POST',
        url: '{{ route("categories.getEditFormB") }}',
        data: { '_token': '<?php echo csrf_token(); ?>', 'id': id },
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
            'category_name': name,
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
        data: { '_token': '<?php echo csrf_token(); ?>', 'id': id },
        success: function(data) {
            if (data.status == "oke") {
                $('#tr_' + id).remove();
            }
        }
    });
}
</script>
@endpush