<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = Article::with('author');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(12);

        $stats = [
            'total' => Article::count(),
            'published' => Article::published()->count(),
            'draft' => Article::draft()->count(),
        ];

        return view('admin.articles.index', compact('articles', 'stats', 'status'));
    }

    public function create()
    {
        $authors = User::admins()->orderBy('name')->get();
        return view('admin.articles.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'nullable|url',
            'status' => 'required|in:draft,published',
            'author_id' => 'required|exists:users,id',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);

        Article::create($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function show(Article $article)
    {
        $article->load('author');

        return view('admin.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $authors = User::admins()->orderBy('name')->get();

        return view('admin.articles.edit', compact('article', 'authors'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'nullable|url',
            'status' => 'required|in:draft,published',
            'author_id' => 'required|exists:users,id',
        ]);

        // Only update slug if title changed
        if ($article->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
