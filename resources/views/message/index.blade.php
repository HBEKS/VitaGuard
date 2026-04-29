@extends('layouts.adminlte4')
@section('title', 'Messages')
@section('sidebar-chat', 'active')

@section('content')
<div class="container">
    <h2>Messages</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Appointment</th>
                <th>Sender</th>
                <th>Message</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($messages as $m)
            <tr>
                <td>{{ $m->appointment_id }}</td>
                <td>{{ $m->sender->name }}</td>
                <td>{{ $m->message }}</td>
                <td>{{ $m->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection