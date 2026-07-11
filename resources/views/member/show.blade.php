@extends('layouts.orbit')

@section('title', $article->title)

@push('styles')
<style>
    .article-content {
        font-size: 18px;
        line-height: 2;
        text-align: justify;
    }

    .article-content p {
        margin-bottom: 20px;
    }

    .article-content img {
        max-width: 100%;
        border-radius: 20px;
        margin: 20px 0;
    }

    .project-card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .image-wrapper {
        aspect-ratio: 16/9;
        overflow: hidden;
    }

    .image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .project-info {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .project-info p {
        flex: 1;
    }
</style>
@endpush

@section('content')
<section class="section py-5">
    <div class="container">
        <a href="{{ route('member.article') }}" class="btn btn-outline-primary mb-4">
            <i class="bi bi-arrow-left"></i>
            Back to List Articles
        </a>
        <a href="{{ route('member.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-house me-1"></i> Back to Home
        </a>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-3">
                    <span class="badge bg-success">
                        Health Article
                    </span>

                    <span class="ms-3">
                        <i class="bi bi-calendar"></i>
                        {{ $article->created_at->format('d F Y') }}
                    </span>

                    <span class="ms-3">
                        <i class="bi bi-person"></i>
                        {{ $article->author->name ?? 'Penulis' }}
                    </span>
                </div>

                <h1 class="display-5 fw-bold mb-4">
                    {{ $article->title }}
                </h1>

                @if($article->image_url)
                <img
                    src="{{ asset('storage/'.$article->image_url) }}"
                    class="img-fluid rounded-4 shadow mb-5 w-100"
                    style="max-height:500px;object-fit:cover;"
                    onerror="this.onerror=null; this.src='https://via.placeholder.com/800x500?text=No+Image';">
                @endif

                <div class="article-content">
                    {!! nl2br(e($article->content)) !!}
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section pb-5">
    <div class="container">
        <div class="section-title">
            <h2>
                Related Articles
            </h2>
        </div>

        <div class="row">
            @foreach($relatedArticles as $related)
            <div class="col-lg-4">
                <div class="project-card">
                    <div class="image-wrapper">
                        @if($related->image_url)
                        <img
                            src="{{ asset('storage/'.$related->image_url) }}"
                            class="card-img-top article-image"
                            onerror="this.onerror=null; this.src='https://via.placeholder.com/400x225?text=No+Image';">
                        @endif
                    </div>

                    <div class="project-info mt-3">
                        <h4>
                            {{ $related->title }}
                        </h4>

                        <p>
                            {{ Str::limit(strip_tags($related->content), 80) }}
                        </p>

                        <a
                            href="{{ route('member.article.show', $related->id) }}"
                            class="btn btn-outline-primary">
                            Read More
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
