@extends('layouts.adminlte4')
@section('title', 'Appointments')
@section('sidebar-booking', 'active')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Appointments</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr scope="col" class="text-center" >
                    <th>ID</th>
                    <th>Doctor</th>
                    <th>Patient</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $a)
                <tr>
                    <td class="text-center"><span class="badge bg-secondary">{{ $a->id }}</span></td>
                    <td>{{ $a->doctor->name ?? '-' }}</td>
                    <td>{{ $a->member->name ?? '-' }}</td>
                    <td>
                        @php
                            // Cek apakah service ini tersedia untuk dokter yang dipilih
                            $isValidService = DB::table('doctor_service')
                                ->where('doctor_profile_id', $a->doctor->doctorProfile?->id)
                                ->where('service_id', $a->service_id)
                                ->exists();
                        @endphp

                        @if($isValidService)
                            <span class="badge bg-success">
                                {{ $a->service->service_name ?? '-' }}
                            </span>
                        @else
                            <span class="badge bg-warning text-dark">
                                {{ $a->service->service_name ?? '-' }}
                            </span>
                        @endif
                    </span></span></td>
                    <td>{{ $a->appointment_date }}</span></span></td>
                    <td>
                        @php
                            $statusColors = [
                                'pending' => 'warning',
                                'confirmed' => 'primary',
                                'completed' => 'success',
                                'cancelled' => 'danger',
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$a->status] ?? 'secondary' }}">
                            {{ $a->status }}
                        </span>
                    </span></span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <hr class="my-4">

        <div class="d-flex gap-3 justify-content-center">
            <a href="{{ url('dashboard/transaction') }}" class="btn btn-warning">
                <i class="fas fa-stethoscope"></i> View Transactions
            </a>
            <a href="{{ url('/') }}" class="btn btn-outline-dark">
                <i class="fas fa-home"></i> Back to Home
            </a>
        </div>
</div>
@endsection
