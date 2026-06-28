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
        // Tampilkan loading
        $('#detail-title').html('Loading...');
        $('#detail-body').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin fa-2x"></i> Loading...</div>');

        // Buka modal
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
                console.log('Data:', data);
                if (data.status == 'oke') {
                    $('#detail-title').html(data.title);
                    $('#detail-body').html(data.body);
                } else {
                    $('#detail-title').html('Error');
                    $('#detail-body').html('<div class="alert alert-danger">' + (data.body || 'Terjadi kesalahan') + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.log('Response:', xhr.responseText);
                $('#detail-title').html('Error');
                $('#detail-body').html('<p class="text-danger">Gagal memuat data layanan</p>');
            }
        });
    }
</script>

<div class="container mt-4">
    <div class="container-table">
        <h1 class="mb-4">Categories List</h1>

        @if (@session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="table-responsive">
            <div id="showinfo"></div>
            <!-- pagination -->
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
                    <!-- <small class="text-muted">
                        Showing {{ $allCategories->firstItem() }}
                        to {{ $allCategories->lastItem() }}
                        of {{ $allCategories->total() }} results
                    </small> -->
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
                        @if(Auth::user()->role == "admin")
                        <th scope="col" class="text-center" style="width: 100px;">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($allCategories as $cat)
                    <tr>
                        <!-- id -->
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $cat->id }}</span>
                        </td>
                        <!-- name -->
                        <td class="fw-bold text-primary">{{ $cat->category_name }}</td>
                        <!-- image -->
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#imageModal-{{ $cat->id }}">
                                <i class="fas fa-image"></i> Show Image
                            </button>
                        </td>
                        <!-- total service -->
                        <td class="text-center">
                            <span class="badge bg-info rounded-pill">{{ $cat->services->count() }}</span>
                        </td>
                        <!-- list service -->
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" onclick="showDetail('{{ $cat->id }}')">
                                <i class="fas fa-list"></i> Details
                            </button>
                        </td>
                        @if(Auth::user()->role == "admin")
                        <td>
                            
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                            No categories found. Please run seeder.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <hr class="my-4">

        @if(Auth::user()->role == "admin")
        <div class="d-flex gap-3 justify-content-center">
            <a href="{{route('categories.create')}}" class="btn btn-primary">+ New Category</a>
            <a href="{{ url('dashboard/services') }}" class="btn btn-warning">
                <i class="fas fa-stethoscope"></i> View Services
            </a>
            <a href="{{ url('/') }}" class="btn btn-outline-dark">
                <i class="fas fa-home"></i> Back to Home
            </a>
        </div>
        @endif
    </div>

    <!-- Modals untuk setiap kategori (Show Image) -->
    @foreach($allCategories as $cat)
    <div class="modal fade" id="imageModal-{{ $cat->id }}" tabindex="-1" aria-labelledby="imageModalLabel-{{ $cat->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel-{{ $cat->id }}">
                        <i class="fas fa-image me-2"></i> Picture for Category: {{ $cat->category_name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <img src="{{ $imageUrl }}"
                        alt="{{ $cat->category_name }}"
                        class="img-fluid rounded"
                        style="max-height: 300px;">
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

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="detail-title">
                        <i class="fas fa-list me-2"></i> Service List
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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

</div>
@endsection
