@extends('layouts.adminlte4')
@section('title', 'Artikel')
@section('sidebar-artikel', 'active')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Daftar Artikel</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div id="ajax-alert"></div>

    @can('create-permission', Auth::user())
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCreate">
        + New Article
    </button>
    @endcan

    <hr>
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control"
                placeholder="Cari artikel..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    <div class="row" id="articles-list">
        @foreach ($articles as $article)
        <div class="col-md-4 mb-4" id="card_article_{{ $article->id }}">
            <div class="card shadow-sm h-100">
                <a href="{{ route('article.show', $article->id) }}" class="text-decoration-none">
                    @if ($article->image_url)
                    <img src="{{ asset('storage/' . $article->image_url) }}" class="card-img-top article-img" style="height:200px; object-fit:cover;">
                    @else
                    <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center article-img-placeholder" style="height:200px;">
                        No Image
                    </div>
                    @endif
                </a>

                <div class="card-body d-flex flex-column">
                    <a href="{{ route('article.show', $article->id) }}" class="text-decoration-none text-dark">
                        <h5 class="fw-bold article-title">{{ $article->title }}</h5>
                    </a>
                    <small class="text-muted mb-2">{{ $article->author->name ?? 'Unknown' }}</small>
                    <p class="card-text article-content">{{ Str::limit($article->content, 50) }}</p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <small class="text-muted">{{ $article->created_at->format('d M Y') }}</small>
                        <a href="{{ route('article.show', $article->id) }}" class="btn btn-sm btn-primary">
                            Baca Selengkapnya →
                        </a>
                    </div>
                    @can('update-permission', Auth::user())
                    <div class="mt-2 d-flex gap-2">
                        <a href="#modalEditB" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            onclick="getEditFormB('{{ $article->id }}')">Edit</a>
                        @can('delete-permission', Auth::user())
                        <a href="#" class="btn btn-sm btn-danger"
                            onclick="if(confirm('Hapus artikel ini?')) deleteDataRemove('{{ $article->id }}')">Delete</a>
                        @endcan
                    </div>
                    @endcan
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Modal Create --}}
    <div class="modal fade" id="modalCreate" tabindex="-1" role="basic">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Article</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('article.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" id="create_title" class="form-control" placeholder="Article title" required>
                        </div>
                        <div class="mb-3">
                            <label>Content</label>
                            <textarea name="content" id="create_content" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Image</label>
                            <input type="file" name="image" id="create_image" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" id="create_status" class="form-select">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit B --}}
    <div class="modal fade" id="modalEditB" tabindex="-1" role="basic">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Article</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalContentB"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('script')
<script>
    function getEditFormB(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("articles.getEditFormB") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'id': id
            },
            success: function(data) {
                $('#modalContentB').html(data.msg);
            }
        });
    }

    function saveDataUpdate(id) {
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('id', id);
        formData.append('title', $('#edit_title').val());
        formData.append('content', $('#edit_content').val());
        formData.append('status', $('#edit_status').val());
        if ($('#edit_image')[0].files[0]) {
            formData.append('image', $('#edit_image')[0].files[0]);
        }

        $.ajax({
            type: 'POST',
            url: '{{ route("articles.saveDataUpdate") }}',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.status == "oke") {
                    var modalEl = document.getElementById('modalEditB');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();

                    var targetCard = $('#card_article_' + id);
                    targetCard.find('.article-title').text($('#edit_title').val());

                    var rawContent = $('#edit_content').val();
                    var limitedContent = rawContent.length > 50 ? rawContent.substring(0, 50) + '...' : rawContent;
                    targetCard.find('.article-content').text(limitedContent);

                    if (data.image_url) {
                        var imgTag = targetCard.find('.article-img');
                        if (imgTag.length) {
                            imgTag.attr('src', '{{ asset("storage") }}/' + data.image_url);
                        } else {
                            targetCard.find('.article-img-placeholder').replaceWith(
                                `<img src="{{ asset("storage") }}/${data.image_url}" class="card-img-top article-img" style="height:200px; object-fit:cover;">`
                            );
                        }
                    }
                }
            }
        });
    }

    function deleteDataRemove(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("articles.deleteData") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'id': id
            },
            success: function(data) {
                if (data.status == "oke") {
                    $('#card_article_' + id).fadeOut(300, function() {
                        $(this).remove();
                    });
                }
            }
        });
    }
</script>
@endpush
