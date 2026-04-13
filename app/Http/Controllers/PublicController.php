<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Models\Specialization;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $featuredArticles = Article::published()
            ->with('author')
            ->latest()
            ->take(3)
            ->get();

        $doctors = User::doctors()
            ->with(['doctorProfile.specialization'])
            ->withCount('doctorAppointments')
            ->orderBy('name')
            ->take(6)
            ->get();

        $specializations = Specialization::withCount('doctorProfiles')
            ->orderBy('name')
            ->take(8)
            ->get();

        return view('public.home', compact('featuredArticles', 'doctors', 'specializations'));
    }

    public function articles(Request $request)
    {
        $query = Article::published()->with('author');

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('content', 'like', "%{$request->search}%");
            });
        }

        $articles = $query->latest()->paginate(9);

        return view('public.articles.index', compact('articles'));
    }

    public function showArticle($slug)
    {
        $article = Article::where('slug', $slug)
            ->published()
            ->with('author')
            ->firstOrFail();

        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(3)
            ->get();

        return view('public.articles.show', compact('article', 'relatedArticles'));
    }

    public function doctors(Request $request)
    {
        $query = User::doctors()
            ->with(['doctorProfile.specialization', 'schedules' => function ($q) {
                $q->active();
            }]);

        if ($request->has('specialization')) {
            $query->whereHas('doctorProfile', function ($q) use ($request) {
                $q->where('specialization_id', $request->specialization);
            });
        }

        if ($request->has('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $doctors = $query->orderBy('name')->paginate(12);

        $specializations = Specialization::withCount('doctorProfiles')
            ->orderBy('name')
            ->get();

        return view('public.doctors.index', compact('doctors', 'specializations'));
    }

    public function showDoctor(User $doctor)
    {
        if (!$doctor->isDoctor()) {
            abort(404);
        }

        $doctor->load(['doctorProfile.specialization', 'schedules' => function ($q) {
            $q->active()->orderBy('day_of_week')->orderBy('start_time');
        }]);

        return view('public.doctors.show', compact('doctor'));
    }

    public function specializations()
    {
        $specializations = Specialization::withCount('doctorProfiles')
            ->orderBy('name')
            ->get();

        return view('public.specializations.index', compact('specializations'));
    }

    public function showSpecialization(Specialization $specialization)
    {
        $doctors = User::doctors()
            ->whereHas('doctorProfile', function ($q) use ($specialization) {
                $q->where('specialization_id', $specialization->id);
            })
            ->with('doctorProfile')
            ->orderBy('name')
            ->paginate(12);

        return view('public.specializations.show', compact('specialization', 'doctors'));
    }
}
