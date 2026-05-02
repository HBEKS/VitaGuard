@extends('layouts.adminlte4')

@section('title', 'Artikel')
@section('sidebar-artikel', 'active')

@section('content')
<div class="container mt-4">

    <h2 class="mb-3">Daftar Artikel</h2>
    <hr>

    <div class="row">
        @foreach ($articles as $article)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <!-- LINK menggunakan route artikel.show dengan ID -->
                <a href="{{ route('artikel.show', $article->id) }}" class="text-decoration-none">
                    @if ($article->image_url)
                    <img src="{{ asset('storage/' . $article->image_url) }}" class="card-img-top" style="height:200px; object-fit:cover;">
                    @else
                    <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height:200px;">
                        No Image
                    </div>
                    @endif
                </a>

                <div class="card-body d-flex flex-column">
                    <!-- JUDUL menjadi LINK -->
                    <a href="{{ route('artikel.show', $article->id) }}" class="text-decoration-none text-dark">
                        <h5 class="fw-bold">{{ $article->title }}</h5>
                    </a>

                    <small class="text-muted mb-2">
                        {{ $article->author->name ?? 'Unknown' }}
                    </small>

                    <p class="card-text">
                        {{ Str::limit($article->content, 50) }}
                    </p>

                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            {{ $article->created_at->format('d M Y') }}
                        </small>

                        <!-- TOMBOL BACA SELENGKAPNYA -->
                        <a href="{{ route('artikel.show', $article->id) }}" class="btn btn-sm btn-primary">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
