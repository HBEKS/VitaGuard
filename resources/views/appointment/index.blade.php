@extends('layouts.adminlte4')
@section('title', 'Appointments')
@section('sidebar-booking', 'active')

@section('content')
<div class="container">
    <h2>Appointments</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
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
                    <td>{{ $a->id }}</span></span></td>
                    <td>{{ $a->doctor->name ?? '-' }}</span></span></td>
                    <td>{{ $a->member->name ?? '-' }}</span></span></td>
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
</div>
@endsection
