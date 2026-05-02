@extends('layouts.adminlte4')

@section('title', $article->title)
@section('sidebar-artikel', 'active')

@section('content')
<div class="container mt-4">

    <!-- Breadcrumb / Navigasi -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}" class="text-decoration-none">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('artikel') }}" class="text-decoration-none">Artikel</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ Str::limit($article->title, 50) }}
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <!-- Judul Artikel -->
                    <h1 class="display-6 fw-bold mb-3">{{ $article->title }}</h1>

                    <!-- Informasi Artikel -->
                    <div class="mb-4 pb-2 border-bottom">
                        <div class="d-flex flex-wrap gap-3 text-muted">
                            <small>
                                <i class="fas fa-user"></i>
                                {{ $article->author->name ?? 'Unknown Author' }}
                            </small>
                            <small>
                                <i class="fas fa-calendar-alt"></i>
                                {{ $article->created_at->format('d F Y') }}
                            </small>
                            <small>
                                <i class="fas fa-clock"></i>
                                {{ $article->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>

                    <!-- Gambar Artikel -->
                    @if ($article->image_url)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $article->image_url) }}"
                             class="img-fluid rounded shadow-sm"
                             alt="{{ $article->title }}"
                             style="max-height: 500px; width: auto;">
                    </div>
                    @endif

                    <!-- Konten Lengkap -->
                    <div class="article-content" style="font-size: 1.1rem; line-height: 1.8;">
                        {!! nl2br(e($article->content)) !!}
                    </div>

                    <!-- Tombol Navigasi -->
                    <div class="mt-5 pt-3 border-top">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('artikel') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Artikel
                            </a>
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-tachometer-alt"></i> Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .article-content {
        text-align: justify;
    }

    .article-content p {
        margin-bottom: 1.2rem;
    }

    .article-content h2,
    .article-content h3 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .card {
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
    }
</style>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@endsection
