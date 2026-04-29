@extends('layouts.adminlte4')

@section('title', 'Jadwal Dokter')
@section('sidebar-booking', 'active')

@section('content')
<div class="container mt-4">

    <h2 class="mb-3">Jadwal Dokter</h2>
    <hr>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Nama Dokter</th>
                        <th>Hari</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $s)
                    <tr>
                        <td>{{ $s->doctor->name }}</td>
                        <td>{{ $s->day_of_week }}</td>
                        <td>{{ $s->start_time }}</td>
                        <td>{{ $s->end_time }}</td>
                        <td>
                            @if($s->is_active)
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection