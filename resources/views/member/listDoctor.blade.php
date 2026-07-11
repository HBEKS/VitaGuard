@extends('layouts.orbit')

@section('title', 'Doctor List')

@section('content')
<section class="section py-5">
    <div class="container">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-primary">Our Expert Doctors</h2>
                <p class="text-muted mb-0">Temukan dan hubungi dokter spesialis sesuai kebutuhan medis Anda.</p>
            </div>
            <span class="badge bg-primary px-3 py-2 rounded-pill fs-6">
                {{ $doctors->total() }} Doctors Available
            </span>
        </div>

        {{-- Panel Filter & Pagination Control --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-light p-3">
            <form method="GET" action="{{ route('member.listDoctor') }}" class="row g-3 align-items-center">

                {{-- Filter Specialization --}}
                <div class="col-md-5 col-sm-6">
                    <label class="form-label small fw-bold text-muted mb-1">Filter Specialization</label>
                    <select name="specialization" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">-- All Specializations --</option>
                        @foreach($specializations as $spec)
                            <option value="{{ $spec->id }}" {{ request('specialization') == $spec->id ? 'selected' : '' }}>
                                {{ $spec->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Show Entries --}}
                <div class="col-md-3 col-sm-6">
                    <label class="form-label small fw-bold text-muted mb-1">Show Entries</label>
                    <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 Per Page</option>
                        <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15 Per Page</option>
                        <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25 Per Page</option>
                    </select>
                </div>

                {{-- Reset Button --}}
                <div class="col-md-4 col-sm-12 d-flex align-items-end">
                    @if(request('specialization') || request('per_page'))
                        <a href="{{ route('member.listDoctor') }}" class="btn btn-outline-secondary btn-sm rounded-3">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filter
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Grid Cards List Doctor --}}
        <div class="row g-4">
            @forelse($doctors as $doctor)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative hover-shadow">
                    <div class="card-body p-4 text-center">

                        {{-- Avatar Foto Dokter --}}
                        <div class="mb-3 position-relative d-inline-block">
                            @if($doctor->avatar && file_exists(public_path('storage/' . $doctor->avatar)))
                                <img src="{{ asset('storage/' . $doctor->avatar) }}"
                                     width="100" height="100"
                                     class="rounded-circle border border-3 border-primary shadow-sm"
                                     style="object-fit:cover;"
                                     alt="{{ $doctor->name }}">
                            @else
                                <i class="bi bi-person-circle text-primary" style="font-size: 90px;"></i>
                            @endif
                        </div>

                        {{-- Nama Dokter --}}
                        <h5 class="fw-bold mb-1">{{ $doctor->name }}</h5>

                        {{-- Spesialisasi (Menampilkan Spesialisasi tanpa STR) --}}
                        <p class="text-primary fw-semibold mb-2">
                            <i class="bi bi-patch-check-fill me-1"></i>
                            {{ $doctor->doctorProfile?->specialization?->name ?? 'General Practitioner' }}
                        </p>

                        {{-- Pengalaman Kerja --}}
                        <div class="mb-3">
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                <i class="bi bi-briefcase me-1 text-primary"></i>
                                {{ $doctor->doctorProfile?->experience_years ?? 0 }} Years Experience
                            </span>
                        </div>

                        {{-- Daftar Layanan / Services --}}
                        <div class="mb-2">
                            <small class="d-block text-muted mb-1 fw-semibold">Services Offered:</small>
                            @forelse($doctor->doctorProfile?->services ?? [] as $service)
                                <span class="badge bg-info-subtle text-info border border-info px-2 py-1 mb-1 rounded-2">
                                    {{ $service->service_name }}
                                </span>
                            @empty
                                <span class="text-muted small">-</span>
                            @endforelse
                        </div>

                    </div>

                    {{-- Tombol Booking / Janji Temu --}}
                    {{-- <div class="card-footer bg-light border-0 p-3 text-center">
                        <a href="{{ route('booking.index') }}" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-semibold">
                            <i class="bi bi-calendar-plus me-1"></i> Book Appointment
                        </a>
                    </div> --}}
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-person-x text-muted" style="font-size: 60px;"></i>
                <h4 class="mt-3 text-muted fw-bold">No doctors found.</h4>
                <p class="text-muted">Tidak ada dokter yang sesuai dengan kriteria atau filter yang dipilih.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination Bawah --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $doctors->withQueryString()->links() }}
        </div>

    </div>
</section>
@endsection
