@extends('layouts.adminlte4')
@section('title', 'Appointments')
@section('sidebar-booking', 'active')

@section('content')
<div class="container">
    <h2>Appointments</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Doctor</th>
                <th>Patient</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $a)
            <tr>
                <td>{{ $a->id }}</td>
                <td>{{ $a->doctor->name }}</td>
                <td>{{ $a->member->name }}</td>
                <td>{{ $a->appointment_date }}</td>
                <td>{{ $a->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
