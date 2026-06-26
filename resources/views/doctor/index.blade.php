@extends('layouts.adminlte4')
@section('title', 'Doctor List')
@section('sidebar-doctors', 'active')
@section('breadcrumb')
<li class="breadcrumb-item active">Doctors</li>
@endsection
@section('content')

<div class="container mt-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Doctor List</h1>
        <span class="badge bg-primary fs-6">
            {{ $doctors->total() }} Doctors
        </span>
    </div>

    {{-- Show Entries + Pagination --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" class="d-flex align-items-center">
            <label class="me-2 mb-0">Show</label>
            <select
                name="per_page"
                class="form-select form-select-sm"
                style="width:80px"
                onchange="this.form.submit()">

                <option value="5" {{ request('per_page',5)==5?'selected':'' }}>5</option>
                <option value="10" {{ request('per_page')==10?'selected':'' }}>10</option>
                <option value="25" {{ request('per_page')==25?'selected':'' }}>25</option>

            </select>
            <span class="ms-2">entries</span>
        </form>
        {{ $doctors->withQueryString()->links() }}
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Photo</th>
                    <th>Name</th>
                    <th>Specialization</th>
                    <th>Services</th>
                    <th>Experience</th>
                    <th>STR Number</th>

                    @if(Auth::user()->role=="admin")
                        <th class="text-center">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @forelse($doctors as $doctor)
                <tr>
                    {{-- ID --}}
                    <td class="text-center">
                        <span class="badge bg-secondary">
                            {{ $doctor->id }}
                        </span>
                    </td>
                    {{-- Avatar --}}
                    <td class="text-center">
                        @if($doctor->avatar && file_exists(public_path('adminlte4/assets/'.$doctor->avatar)))
                            <img
                                src="{{ asset('adminlte4/assets/'.$doctor->avatar) }}"
                                width="60"
                                height="60"
                                class="rounded-circle"
                                style="object-fit:cover;"
                            >
                        @else
                            <i class="bi bi-person-circle text-primary"
                               style="font-size:50px;">
                            </i>
                        @endif
                    </td>
                    {{-- Name --}}
                    <td>
                        {{ $doctor->name }}
                    </td>

                    {{-- Specialization --}}
                    <td>
                        {{ $doctor->doctorProfile?->specialization?->name ?? '-' }}
                    </td>

                    {{-- Services --}}
                    <td>
                        @forelse($doctor->doctorProfile?->services ?? [] as $service)
                            <span class="badge bg-info mb-1">
                                {{ $service->service_name }}
                            </span>
                        @empty
                            -
                        @endforelse
                    </td>

                    {{-- Experience --}}
                    <td>
                        {{ $doctor->doctorProfile?->experience_years ?? '-' }}
                        Years
                    </td>

                    {{-- STR --}}
                    <td>
                        {{ $doctor->doctorProfile?->str_number ?? '-' }}
                    </td>

                    {{-- Action --}}
                    @if(Auth::user()->role=="admin")

                    <td class="text-center">
                        <button class="btn btn-warning btn-sm">
                            Edit
                        </button>
                    </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        No doctors found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection