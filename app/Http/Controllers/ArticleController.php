<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search');

        $query = Article::with('author');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(12);

        $stats = [
            'total' => Article::count(),
            'published' => Article::published()->count(),
            'draft' => Article::draft()->count(),
        ];

        return view('article.index', compact('articles', 'stats', 'status'));
    }

    public function indexMember(Request $request)
    {
        $search = $request->query('search');

        // Member HANYA bisa membaca artikel yang statusnya 'published'
        $query = Article::with('author')->where('status', 'published');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(9);

        return view('member.listArticle', compact('articles'));
    }

    public function store(Request $request)
    {
        $article = Article::create([
            'author_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'content' => $request->content,
            'status' => $request->status ?? 'draft',
        ]);

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $filename = $article->id . '.' . $file->getClientOriginalExtension();

            $file->move(
                public_path('storage/img/articles/'),
                $filename
            );

            $article->image_url = 'img/articles/' . $filename;
            $article->save();
        }

        return redirect()->route('article')
            ->with('success', 'Artikel berhasil ditambahkan.');

        return response()->json([
            'status' => 'oke',
            'msg' => 'Article created!'
        ]);
    }

    public function show(Article $article)
    {
        $relatedArticles = Article::where('id', '!=', $article->id)
            ->latest()
            ->take(3)
            ->get();

        return view(
            'article.show',
            compact(
                'article',
                'relatedArticles'
            )
        );
    }

    public function showMember($id)
    {
        $article = Article::with('author')->findOrFail($id);
        $relatedArticles = Article::where('id', '!=', $id)
            ->where('status', 'published')
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('member.show', compact('article', 'relatedArticles'));
    }

    public function getEditFormB(Request $request)
    {
        $data = Article::find($request->id);

        return response()->json([
            'status' => 'oke',
            'msg' => view('article.getEditFormB', compact('data'))->render(),
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $data = Article::find($request->id);
        $data->title   = $request->title;
        $data->content = $request->content;
        $data->status  = $request->status;

        if ($request->hasFile('image')) {
            if ($data->image_url && File::exists(public_path('storage/' . $data->image_url))) {
                File::delete(public_path('storage/' . $data->image_url));
            }
            $file = $request->file('image');
            $filename = 'article-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/img/articles/'), $filename);
            $data->image_url = 'img/articles/' . $filename;
        }

        $data->save();
        return response()->json(['status' => 'oke', 'msg' => 'Article updated!'], 200);
    }
    public function deleteData(Request $request)
    {
        $data = Article::find($request->id);
        $data->delete();

        return response()->json(['status' => 'oke', 'msg' => 'Article deleted!'], 200);
    }

    public function create() {}

    public function edit(Article $article) {}

    public function update(Request $request, Article $article) {}

    public function destroy(Article $article) {}
}
