@extends('layouts.adminlte4')
@section('title', 'Transactions')
@section('sidebar-transaksi', 'active')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Transactions</h1>

    <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-light">
            <tr scope="col" class="text-center" >
                <!-- <th>ID</th> -->
                <th>Appointment</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $t)
            <tr>
                <!-- <td>{{ $t->id }}</td> -->
                <td class="text-center"><span class="badge bg-secondary">{{ $t->appointment_id }}</span></td>
                <td>Rp {{ number_format($t->amount, 0, ',', '.') }}</td>
                <td>{{ $t->payment_method }}</td>
                <td>{{ $t->payment_status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr class="my-4">

        <div class="d-flex gap-3 justify-content-center">
            <a href="{{ url('dashboard/booking') }}" class="btn btn-warning">
                <i class="fas fa-stethoscope"></i> View Appointments
            </a>
            <a href="{{ url('/') }}" class="btn btn-outline-dark">
                <i class="fas fa-home"></i> Back to Home
            </a>
        </div>
</div>
@endsection