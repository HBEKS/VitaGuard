@extends('layouts.adminlte4')
@section('title', 'Transactions')
@section('sidebar-transaksi', 'active')

@section('content')
<div class="container">
    <h2>Transactions</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Appointment</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>{{ $t->appointment_id }}</td>
                <td>Rp {{ number_format($t->amount, 0, ',', '.') }}</td>
                <td>{{ $t->payment_method }}</td>
                <td>{{ $t->payment_status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection