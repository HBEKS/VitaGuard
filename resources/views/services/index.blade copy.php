@extends('layouts.adminlte4')

@section('title', 'Service List')

@section('sidebar-services', 'active')

@section('breadcrumb')
    <li class="breadcrumb-item active">Services</li>
@endsection

@section('content')
<div class="container mt-4">
    <div class="page-header">
        <h1 class="mb-4">
            <!-- <i class="fas fa-stethoscope"></i> -->
            Services List
        </h1>
        <div class="d-flex align-items-center gap-3">
            <!-- <span class="stats-badge">
                <i class="fas fa-list me-2"></i>
                {{ count($services) }} Services per page
            </span> -->
            <!-- <a href="{{ url('/') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a> -->
        </div>
    </div>

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
            Showing {{ $services->firstItem() }}
            to {{ $services->lastItem() }}
            of {{ $services->total() }} results
        </small> -->
        {{ $services->links() }}
    </div>

    <div class="table-container">
        <div class="table-responsive">             
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-center" width="5%">ID</th>
                        <th scope="col" class="text-center" width="15%">Service Name</th>
                        <th scope="col" class="text-center" width="15%">Description</th>
                        <th scope="col" class="text-center" width="15%">Availability</th>
                        <th scope="col" class="text-center" width="12%">Price</th>
                        <th scope="col" class="text-center" width="10%">Category Name</th>
                        @if(Auth::user()->role == "admin")
                            <th scope="col" class="text-center" width="5%">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $item)
                    <tr>
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $item->id }}</span>
                        </td>
                        <td>
                            <div class="service-name">
                                <i class="fas fa-briefcase-medical text-primary me-2"></i>
                                <!-- any idea why ini dibuat routing? -->
                                <!-- <a href={{ route('services.show', $item->id) }} class="fw-bold text-primary" style="text-decoration: none;">
                                    {{ $item->service_name }}
                                </a> -->
                                {{$item->service_name}}
                            </div>
                        </td>
                        <td style="white-space: normal;">
                            <i class="fas fa-align-left text-muted me-2"></i>
                            {{$item->description}}
                        </td>
                        <td>
                            <span class="availability-badge">
                                <i class="far fa-clock me-1"></i>
                                {{ $item->availability }}
                            </span>
                        </td>
                        <td>
                            <span class="price-tag">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </span>
                        </td>
                        <td>
                            <span>
                                {{ $item->category->category_name }}
                            </span>
                        </td>
                        @if(Auth::user()->role == "admin")
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" onclick="">
                                <i class="fas fa-list"></i> Edit
                            </button>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        
        </div>
    </div>

    <hr class="my-4">
    
    @if (Auth::user()->role == "admin")
    <div class="d-flex gap-3 justify-content-center">
            <a href="{{route('services.create')}}" class="btn btn-primary">+ New Service</a>
            <a href="{{ url('dashboard/categories') }}" class="btn btn-warning">
                <i class="fas fa-stethoscope"></i> View Categories
            </a>
            <a href="{{ url('/') }}" class="btn btn-outline-dark">
                <i class="fas fa-home"></i> Back to Home
            </a>
        </div>
    </div>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
