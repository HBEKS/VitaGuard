@extends('layouts.adminlte4')
@section('title', 'Doctors')
@section('sidebar-doctors', 'active')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Doctor List</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr scope="col" class="text-center" >
                    <th style="width: 50px;">ID</th>
                    <th style="width: 100px;">Photo</th>
                    <th>Name</th>
                    <th style="width: auto;">Specialization</th>
                    <th style="width: 200px;">Services</th>
                    <th style="width: 100px;">Experience</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($doctors as $d)
                <tr>
                    <td class="text-center"><span class="badge bg-secondary">{{ $d->id }}</span></span></td>
                    <td class="text-center" style="width: 100px; padding: 5px;">
                        @php
                        $avatarPath = $d->user->avatar ?? null;
                        $fullPath = $avatarPath ? public_path('storage/' . $avatarPath) : null;
                        $hasValidImage = $avatarPath && $fullPath && file_exists($fullPath);
                        @endphp

                        @if($hasValidImage)
                        <img src="{{ asset('storage/' . $avatarPath) }}"
                            alt="{{ $d->user->name }}"
                            style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                        <img src="{{ asset('storage/img/profiles/default-avatar.jpg') }}"
                            alt="Default Avatar"
                            style="width: 100px; height: 100px; object-fit: cover;">
                        @endif
                    </td>
                    <td>{{ $d->user->name }}</td>
                    <td style="white-space: normal; word-wrap: break-word;">
                        <span class="badge bg-primary" style="font-size: 0.9rem; padding: 8px 12px; white-space: normal; text-align: left;">
                            {{ $d->specialization->name }}
                        </span>
                    </td>
                    <td>
                        @if($d->services && $d->services->count() > 0)
                            @foreach($d->services as $service)
                                <span class="badge bg-secondary mb-1" style="font-size: 0.7rem; display: inline-block; margin-right: 3px;">
                                    {{ $service->service_name }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </span></span></td>
                    <td>{{ $d->experience_years }} years</span></span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
