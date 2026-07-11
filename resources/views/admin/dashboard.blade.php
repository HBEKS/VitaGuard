@extends('layouts.adminlte4')

@section('title','Dashboard')
@section('sidebar-dashboard','active')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="mb-4">
        <h5 class="text-muted">Administrator Dashboard</h5>
        <h1 class="fw-bold">
            Welcome Back, {{ Auth::user()->name }}
        </h1>
    </div>

    {{-- Statistik --}}
    <div class="row">

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $doctorCount }}</h3>
                    <p>Total Doctors</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-md"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $memberCount }}</h3>
                    <p>Total Members</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $articleCount }}</h3>
                    <p>Health Articles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $bookingCount }}</h3>
                    <p>Total Bookings</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $ongoingConsultation }}</h3>
                    <p>Ongoing Consultation</p>
                </div>
                <div class="icon">
                    <i class="fas fa-stethoscope"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $completedConsultation }}</h3>
                    <p>Completed Consultation</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- Chart + Quick Access --}}
    <div class="row mt-4">

        <div class="col-lg-8">

            <div class="card">
                <div class="card-header">
                    <strong>Appointment Status</strong>
                </div>

                <div class="card-body">
                    <div id="statusChart" style="min-height: 350px;"></div>
                </div>
            </div>

        </div>

        <div class="col-lg-4">

            <div class="card">

                <div class="card-header">
                    <strong>Quick Access</strong>
                </div>

                <div class="card-body d-grid gap-2">

                    <a href="{{ route('services.index') }}" class="btn btn-primary">
                        Services
                    </a>

                    <a href="{{ route('categories.index') }}" class="btn btn-success">
                        Categories
                    </a>

                    <a href="{{ route('listDoctor') }}" class="btn btn-info text-white">
                        Doctors
                    </a>

                    <a href="{{ route('members.index') }}" class="btn btn-warning">
                        Members
                    </a>

                    <a href="{{ route('article') }}" class="btn btn-secondary">
                        Articles
                    </a>

                    <a href="{{ route('booking.index') }}" class="btn btn-danger">
                        Appointments
                    </a>

                    <a href="{{ route('profile') }}" class="btn btn-dark">
                        My Profile
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection

@push('script')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Gunakan quotes "" agar VS Code linter membacanya sebagai string biasa
    const pendingCount = parseInt("{{ $pending }}") || 0;
    const confirmedCount = parseInt("{{ $confirmed }}") || 0;
    const completedCount = parseInt("{{ $completed }}") || 0;
    const cancelledCount = parseInt("{{ $cancelled }}") || 0;

    const statusChartEl = document.querySelector("#statusChart");

    if (statusChartEl) {
        statusChartEl.innerHTML = '';

        new ApexCharts(statusChartEl, {
            chart: {
                type: 'pie',
                height: 350
            },
            series: [
                pendingCount,
                confirmedCount,
                completedCount,
                cancelledCount
            ],
            labels: [
                "Pending",
                "Confirmed",
                "Completed",
                "Cancelled"
            ],
            legend: {
                position: 'bottom'
            }
        }).render();
    }
});
</script>
@endpush
