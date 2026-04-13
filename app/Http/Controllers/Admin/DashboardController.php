<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Article;
use App\Models\Appointment;
use App\Models\Specialization;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_doctors' => User::doctors()->count(),
            'total_members' => User::members()->count(),
            'total_articles' => Article::count(),
            'total_appointments' => Appointment::count(),
            'pending_appointments' => Appointment::pending()->count(),
            'completed_appointments' => Appointment::completed()->count(),
            'total_specializations' => Specialization::count(),
            'recent_appointments' => Appointment::with(['member', 'doctor'])
                ->latest()
                ->take(5)
                ->get(),
            'recent_members' => User::members()
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
