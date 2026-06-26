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

        <!-- service -->
        <div class="col-md-4">
            <a href="{{ route('services.index') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Service</h5>
                    <p class="text-muted">Informasi Service yang tersedia</p>
                </div>
            </a>
        </div>

        <!-- category -->
        <div class="col-md-4">
            <a href="{{ route('categories.index') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Category</h5>
                    <p class="text-muted">Informasi Category yang tersedia</p>
                </div>
            </a>
        </div>

        <!-- dokter -->
        <div class="col-md-4">
            <a href="{{ route('listDoctor') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Dokter</h5>
                    <p class="text-muted">Daftar dokter tersedia</p>
                </div>
            </a>
        </div>

        <!-- artikel -->
        <div class="col-md-4">
            <a href="{{ route('article') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Artikel</h5>
                    <p class="text-muted">Lihat informasi kesehatan</p>
                </div>
            </a>
        </div>

        <!-- booking -->
        <div class="col-md-4">
            <a href="{{ route('doctorBooking') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Booking</h5>
                    <p class="text-muted">Janji konsultasi</p>
                </div>
            </a>
        </div>

        <!-- profile -->
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