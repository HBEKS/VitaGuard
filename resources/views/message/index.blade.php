@extends('layouts.adminlte4')
@section('title', 'Messages')
@section('sidebar-chat', 'active')

@section('content')
<div class="container">
    <h1 class="mb-4">Messages</h1>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr scope="col" class="text-center" >
                <th>Appointment</th>
                <th>Sender</th>
                <th>Message</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($messages as $m)
            <tr>
                <td class="text-center"><span class="badge bg-secondary">{{ $m->appointment_id }}</td>
                <td>{{ $m->sender->name }}</td>
                <td>{{ $m->message }}</td>
                <td>{{ $m->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection