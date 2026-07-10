@extends('layouts.adminlte4')
@section('title', 'Artikel')
@section('sidebar-artikel', 'active')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Daftar Artikel</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @can('create-permission', Auth::user())
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCreate">
        + New Article
    </button>
    @endcan

    <hr>

    <div class="row">
        @foreach ($articles as $article)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <a href="{{ route('article.show', $article->id) }}" class="text-decoration-none">
                    @if ($article->image_url)
                    <img src="{{ asset('storage/' . $article->image_url) }}" class="card-img-top" style="height:200px; object-fit:cover;">
                    @else
                    <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height:200px;">
                        No Image
                    </div>
                    @endif
                </a>
                <div class="card-body d-flex flex-column">
                    <a href="{{ route('article.show', $article->id) }}" class="text-decoration-none text-dark">
                        <h5 class="fw-bold">{{ $article->title }}</h5>
                    </a>
                    <small class="text-muted mb-2">{{ $article->author->name ?? 'Unknown' }}</small>
                    <p class="card-text">{{ Str::limit($article->content, 50) }}</p>
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
                </div>
                <form method="POST" action="{{ route('article.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Article title" required>
                        </div>
                        <div class="mb-3">
                            <label>Content</label>
                            <textarea name="content" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Image URL</label>
                            <input type="text" name="image_url" class="form-control" placeholder="img/articles/...">
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select">
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
        data: { '_token': '<?php echo csrf_token(); ?>', 'id': id },
        success: function(data) {
            $('#modalContentB').html(data.msg);
        }
    });
}

function saveDataUpdate(id) {
    $.ajax({
        type: 'POST',
        url: '{{ route("articles.saveDataUpdate") }}',
        data: {
            '_token' : '<?php echo csrf_token(); ?>',
            'id'     : id,
            'title'  : $('#edit_title').val(),
            'content': $('#edit_content').val(),
            'status' : $('#edit_status').val(),
        },
        success: function(data) {
            if (data.status == "oke") {
                $('#modalEditB').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                location.reload();
            }
        }
    });
}

function deleteDataRemove(id) {
    $.ajax({
        type: 'POST',
        url: '{{ route("articles.deleteData") }}',
        data: { '_token': '<?php echo csrf_token(); ?>', 'id': id },
        success: function(data) {
            if (data.status == "oke") {
                location.reload();
            }
        }
    });
}
</script>
@endpush