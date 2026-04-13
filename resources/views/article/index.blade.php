<title>Daftar Artikel</title>
<link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="container mt-4">
    <div class="row">
        <h1>Daftar Artikel</h1>
        <hr>
        @foreach ($articles as $article)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">

                <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height:200px;">
                    Thumbnail
                </div>

                <div class="card-body">
                    <h3>{{ $article->title }}</h3>
                    <h5>{{ $article->id}}</h5>
                    <p class="card-text">
                        {{ $article->content }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <!-- <a href="#" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="#" class="btn btn-sm btn-outline-secondary">Edit</a> -->
                        </div>
                        <small class="text-muted">
                            {{ $article->created_at->format('d M Y') }}
                        </small>
                    </div>
                </div>

            </div>
        </div>
        @endforeach

    </div>
</div>
</div>