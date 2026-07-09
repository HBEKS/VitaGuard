@extends('layouts.adminlte4')

@section('title', 'Dashboard')
@section('sidebar-dashboard', 'active')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="mb-4">
        <h3 class="text-muted">VitaGuard Dashboard</h3>
        <h1 class="mb-4">
            Welcome, {{ Auth::user()->name }}!
        </h1>
    </div>

    <div class="row g-4">

        <!-- Service -->
        <div class="col-md-4">
            <a href="{{ route('services.index') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Services</h5>
                    <p class="text-muted">Daftar Service</p>
                </div>
            </a>
        </div>

        <!-- Categories -->
        <div class="col-md-4">
            <a href="{{ route('categories.index') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Categories</h5>
                    <p class="text-muted">Daftar Categories</p>
                </div>
            </a>
        </div>

        <!-- list dokter -->
        <div class="col-md-4">
            <a href="{{ route('listDoctor') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Dokter</h5>
                    <p class="text-muted">Daftar dokter</p>
                </div>
            </a>
        </div>

        <!-- list member -->
        <div class="col-md-4">
            <a href="{{ route('members.index') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Member</h5>
                    <p class="text-muted">Daftar Member</p>
                </div>
            </a>
        </div>

        <!-- artikel -->
        <div class="col-md-4">
            <a href="{{ route('article') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Artikel</h5>
                    <p class="text-muted">Daftar Artikel</p>
                </div>
            </a>
        </div>

        <!-- list appointment + transaction -->
        <div class="col-md-4">
            <a href="{{ route('doctorBooking') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Consultations</h5>
                    <p class="text-muted">Daftar Janji Konsultasi dan transaksi</p>
                </div>
            </a>
        </div>

        <!-- profile admin -->
        <div class="col-md-4">
            <a href="{{ route('profile') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Profile</h5>
                    <p class="text-muted">Kelola akun</p>
                </div>
            </a>
        </div>

    </div>

</div>
@endsection
