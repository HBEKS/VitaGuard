@extends('layouts.adminlte4')

@section('title', 'Service List')

@section('sidebar-services', 'active')

@section('breadcrumb')
    <li class="breadcrumb-item active">Services</li>
@endsection

@section('content')
    <div class="page-header">
        <h2>
            <i class="fas fa-stethoscope"></i>
            Services List
        </h2>
        <div class="d-flex align-items-center gap-3">
            <span class="stats-badge">
                <i class="fas fa-list me-2"></i>
                {{ count($services) }} Services
            </span>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Service Name</th>
                        <th width="15%">Description</th>
                        <th width="15%">Availability</th>
                        <th width="12%">Price</th>
                        <th width="10%">Category Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $item)
                    <tr>
                        <td>
                            <span class="fw-semibold">{{ $item->id }}</span>
                        </td>
                        <td>
                            <div class="service-name">
                                <i class="fas fa-briefcase-medical text-primary me-2"></i>
                                <a href={{ route('services.show', $item->id) }}>
                                    {{ $item->service_name }}
                                </a>
                            </div>
                        </td>
                        <td>
                            @php
                                $shortDesc = \Illuminate\Support\Str::limit($item->description, 30, '...');
                            @endphp
                            <span class="description-preview" title="{{ $item->description }}">
                                <i class="fas fa-align-left text-muted me-2"></i>
                                {{ $shortDesc }}
                            </span>
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
