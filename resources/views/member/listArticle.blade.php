@extends('layouts.orbit')

@section('title', 'Daftar Artikel Kesehatan')

@section('content')
<div class="page-title accent-background py-5">
    <div class="container position-relative text-center">
        <h1>Artikel Kesehatan</h1>
        <p>Temukan berbagai informasi dan wawasan kesehatan terpercaya dari para ahli kami.</p>
    </div>
</div>

<section class="section py-5">
    <div class="container">

        {{-- Form Pencarian Artikel --}}
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <form method="GET" action="{{ route('member.article') }}">
                    <div class="input-group input-group-lg shadow-sm">
                        <input type="text" name="search" class="form-control"
                               placeholder="Cari artikel kesehatan..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Grid Daftar Artikel --}}
        <div class="row g-4">
            @forelse ($articles as $article)
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                    {{-- Thumbnail Gambar Artikel --}}
                    <a href="{{ route('member.article.show', $article->id) }}" class="text-decoration-none">
                        @if ($article->image_url)
                            <img src="{{ asset('storage/' . $article->image_url) }}"
                                 class="card-img-top"
                                 alt="{{ $article->title }}"
                                 style="height: 220px; object-fit: cover;"
                                 onerror="this.onerror=null; this.src='https://via.placeholder.com/400x220?text=No+Image';">
                        @else
                            <div class="card-img-top bg-light text-muted d-flex align-items-center justify-content-center" style="height: 220px;">
                                <i class="bi bi-image fs-1"></i>
                            </div>
                        @endif
                    </a>

                    {{-- Body Card Artikel --}}
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex align-items-center text-muted small mb-2">
                            <span class="me-3"><i class="bi bi-person me-1"></i>{{ $article->author->name ?? 'Penulis' }}</span>
                            <span><i class="bi bi-calendar me-1"></i>{{ $article->created_at->format('d M Y') }}</span>
                        </div>

                        <a href="{{ route('member.article.show', $article->id) }}" class="text-decoration-none text-dark">
                            <h5 class="fw-bold card-title mb-3">{{ $article->title }}</h5>
                        </a>

                        <p class="card-text text-secondary mb-4">
                            {{ Str::limit(strip_tags($article->content), 90) }}
                        </p>

                        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                            <a href="{{ route('member.article.show', $article->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted">
                    <i class="bi bi-journal-x display-1"></i>
                    <h4 class="mt-3">Artikel Tidak Ditemukan</h4>
                    <p>Coba gunakan kata kunci pencarian yang lain.</p>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $articles->appends(request()->query())->links() }}
        </div>

    </div>
</section>
@endsection
