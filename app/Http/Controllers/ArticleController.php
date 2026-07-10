<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('content', 'like', '%'.$search.'%');
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

    public function store(Request $request)
    {
        $imagePath = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'article-'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('storage/img/articles/'), $filename);
            $imagePath = 'img/articles/'.$filename;
        }

        Article::create([
            'author_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title).'-'.Str::random(5),
            'content' => $request->content,
            'image_url' => $imagePath,
            'status' => $request->status ?? 'draft',
        ]);

        return response()->json(['status' => 'oke', 'msg' => 'Article created!'], 200);
    }

    public function show($id)
    {
        $article = Article::with('author')->find($id);

        return view('article.show', compact('article'));
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
        $data->title = $request->title;
        $data->content = $request->content;
        $data->status = $request->status;
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
