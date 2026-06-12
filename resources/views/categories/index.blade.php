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
</style>
@endpush

@push('scripts')
<script>
    function showInfo(event) {
        if (event) event.preventDefault();

        $.ajax({
            type: 'POST',
            url: '{{ route("categories.showInfo") }}',
            data: {
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                $('#showinfo').html('<div class="text-info"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>');
            },
            success: function(data) {
                $('#showinfo').html(data.msg);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $('#showinfo').html('<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>Gagal memuat data</div>');
            }
        });

        return false;
    }

    function showDetail(id) {
        $('#detail-title').html('Loading...');
        $('#detail-body').html('<p class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i></p>');
        $('#detailModal').modal('show');

        $.ajax({
            type: 'POST',
            url: '{{ route("categories.showListServices") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'idcat': id
            },
            success: function(data) {
                $('#detail-title').html(data.title);
                $('#detail-body').html(data.body);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $('#detail-title').html('Error');
                $('#detail-body').html('<p class="text-danger">Gagal memuat data layanan</p>');
            }
        });
    }
</script>
@endpush

@section('content')
<div class="container mt-4">
    <div class="container-table">
        <h1 class="mb-4">List of Service Categories</h1>
        <p>The <a href="#" onclick="showInfo(); return false;">.table</a> class adds basic styling (light padding and only horizontal dividers) to a table:</p>
        @if (@session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div class="table-responsive">
            <div id="showinfo"></div>
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-center" style="width: 60px;">ID</th>
                        <th scope="col" style="width: 300px;">Category Name</th>
                        <th scope="col" class="text-center" style="width: 150px;">Image</th>
                        <th scope="col" class="text-center" style="width: 130px;">Total Services</th>
                        <th scope="col" class="text-center" style="width: 100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allCategories as $cat)
                    <tr>
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $cat->id }}</span>
                            </span>
                        <td class="fw-bold text-primary">{{ $cat->category_name }}</span>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#imageModal-{{ $cat->id }}">
                                <i class="fas fa-image"></i> Show Image
                            </button>
                            </span>
                        <td class="text-center">
                            <span class="badge bg-info rounded-pill">{{ $cat->services->count() }}</span>
                            </span>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" onclick="showDetail('{{ $cat->id }}')">
                                <i class="fas fa-list"></i> Details
                            </button>
                            </span>
                    </tr>
                    @empty
                    <table>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                            No categories found. Please run seeder.
                            </span>
                            </tr>
                            @endforelse
                </tbody>
            </table>
        </div>

        <hr class="my-4">

        <div class="d-flex gap-3 justify-content-center">
            <a href="{{route('categories.create')}}" class="btn btn-primary">+ New Category</a>
            <a href="{{ url('dashboard/services') }}" class="btn btn-warning">
                <i class="fas fa-stethoscope"></i> View Services
            </a>
            <a href="{{ url('/') }}" class="btn btn-outline-dark">
                <i class="fas fa-home"></i> Back to Home
            </a>
        </div>
    </div>

    <!-- Modals untuk setiap kategori -->
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

                    // List kemungkinan path gambar
                    $possiblePaths = [
                    $cat->image, // dari database (contoh: img/categories/1.jpg)
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
        <div class="modal-dialog modal-lg">
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