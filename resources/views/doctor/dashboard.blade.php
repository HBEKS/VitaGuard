@extends('layouts.adminlte4')

@section('title','Doctor Dashboard')
@section('sidebar-dashboard','active')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                Welcome Back,
                {{ Auth::user()->name }}
            </h2>

            <p class="text-muted">
                {{ \Carbon\Carbon::now()->format('l, d F Y') }}
            </p>
        </div>

        <div class="text-end">
            <h6 class="text-muted mb-0">
                Active Patients
            </h6>
            <h2 class="fw-bold text-primary">
                {{ $activePatients }}
            </h2>
        </div>
    </div>

    <div class="row mb-4">

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Appointment Status</h5>
                </div>

                <div class="card-body">
                    <div id="statusChart" style="min-height: 300px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Appointments per Month</h5>
                </div>

                <div class="card-body">
                    <div id="monthlyChart" style="min-height: 300px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Service Distribution</h5>
                </div>

                <div class="card-body">
                    <div id="serviceChart" style="min-height: 300px;"></div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <h5 class="mb-3">Appointment Statistics</h5>
        <div class="col-lg-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pending }}</h3>
                    <p>Pending</p>
                </div>

                <div class="icon">
                    <i class="bi bi-hourglass"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $confirmed }}</h3>
                    <p>Confirmed</p>
                </div>

                <div class="icon">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $completed }}</h3>
                    <p>Completed</p>
                </div>

                <div class="icon">
                    <i class="bi bi-clipboard2-check"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $total }}</h3>
                    <p>Total Appointment</p>
                </div>

                <div class="icon">
                    <i class="bi bi-bar-chart"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Today's Schedule
                    </h4>
                </div>

                <div class="card-body">
                    @forelse($todayAppointments as $appointment)
                    <div class="border-bottom mb-3 pb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">
                                    {{ $appointment->member->name }}
                                </h5>

                                <small class="text-muted">
                                    {{ $appointment->service->service_name }}
                                </small>
                            </div>

                            <span class="badge bg-primary">
                                {{ $appointment->appointment_time->format('H:i') }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="alert alert-success mb-0">
                        No appointments today.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Quick Access
                    </h4>
                </div>

                <div class="card-body d-grid gap-3">
                    <a href="{{ route('booking') }}"
                        class="btn btn-primary">
                        <i class="bi bi-calendar2-week me-1"></i>
                        My Appointments
                    </a>

                    <a href="{{ route('profile') }}"
                        class="btn btn-success">
                        <i class="bi bi-person-circle me-1"></i>
                        My Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h4>
                Latest Appointments
            </h4>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Complaint</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($recentAppointments as $appointment)
                    <tr>
                        <td>
                            {{ $appointment->member->name }}
                        </td>

                        <td style="white-space: normal;">
                            {{ $appointment->member_complaint }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. Data Integer (Atasi error Linter dengan quotes + parseInt)
        const pendingCount = parseInt("{{ $pending }}") || 0;
        const confirmedCount = parseInt("{{ $confirmed }}") || 0;
        const completedCount = parseInt("{{ $completed }}") || 0;
        const cancelledCount = parseInt("{{ $cancelled }}") || 0;

        // 2. Data Array / JSON
        const monthlyData = JSON.parse('{!! json_encode(collect($monthlyChart)->pluck("count")) !!}');
        const monthlyMonths = JSON.parse('{!! json_encode(collect($monthlyChart)->pluck("month")) !!}');

        const serviceTotals = JSON.parse('{!! json_encode($serviceChart->pluck("total")) !!}');
        const serviceNames = JSON.parse('{!! json_encode($serviceChart->pluck("service.service_name")) !!}');

        // --- CHART 1: APPOINTMENT STATUS ---
        const statusChartEl = document.querySelector("#statusChart");
        if (statusChartEl) {
            statusChartEl.innerHTML = ''; // Bersihkan container dari render ganda
            new ApexCharts(statusChartEl, {
                chart: {
                    type: 'pie',
                    height: 300
                },
                series: [pendingCount, confirmedCount, completedCount, cancelledCount],
                labels: ['Pending', 'Confirmed', 'Completed', 'Cancelled'],
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center'
                }
            }).render();
        }

        // --- CHART 2: MONTHLY APPOINTMENTS ---
        const monthlyChartEl = document.querySelector("#monthlyChart");
        if (monthlyChartEl) {
            monthlyChartEl.innerHTML = '';
            new ApexCharts(monthlyChartEl, {
                chart: {
                    type: 'line',
                    height: 300
                },
                series: [{
                    name: 'Appointments',
                    data: monthlyData
                }],
                xaxis: {
                    categories: monthlyMonths
                }
            }).render();
        }

        // --- CHART 3: SERVICE DISTRIBUTION ---
        const serviceChartEl = document.querySelector("#serviceChart");
        if (serviceChartEl) {
            serviceChartEl.innerHTML = '';
            new ApexCharts(serviceChartEl, {
                chart: {
                    type: 'pie',
                    height: 300
                },
                series: serviceTotals,
                labels: serviceNames,
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center'
                }
            }).render();
        }
    });
</script>
@endpush
