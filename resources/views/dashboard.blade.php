@extends('layouts.adminlte4')

@section('title', 'Dashboard')
@section('sidebar-dashboard', 'active')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="mb-4">
        <h1 class="mb-4">VitaGuard Dashboard</h1>
        <p class="text-muted">Welcome</p>
    </div>

    <div class="row g-4">

        <div class="col-md-4">
            <a href="{{ route('article') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Artikel</h5>
                    <p class="text-muted">Lihat informasi kesehatan</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('doctor') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Dokter</h5>
                    <p class="text-muted">Daftar dokter tersedia</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('booking') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Booking</h5>
                    <p class="text-muted">Buat janji konsultasi</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('chat') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Chat</h5>
                    <p class="text-muted">Konsultasi dengan dokter</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('transaction') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center">
                    <h5>Riwayat</h5>
                    <p class="text-muted">Lihat transaksi</p>
                </div>
            </a>
        </div>

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