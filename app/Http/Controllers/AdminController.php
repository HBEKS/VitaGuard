<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Appointment;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistik
        $doctorCount = User::where('role', 'doctor')->count();

        $memberCount = User::where('role', 'member')->count();

        $articleCount = Article::count();

        $bookingCount = Appointment::count();

        $ongoingConsultation = Appointment::whereIn('status', [
            'pending',
            'confirmed'
        ])->count();

        $completedConsultation = Appointment::where('status', 'completed')->count();

        // Chart
        $pending = Appointment::where('status','pending')->count();
        $confirmed = Appointment::where('status','confirmed')->count();
        $completed = Appointment::where('status','completed')->count();
        $cancelled = Appointment::where('status','cancelled')->count();

        return view('admin.dashboard', compact(
            'doctorCount',
            'memberCount',
            'articleCount',
            'bookingCount',
            'ongoingConsultation',
            'completedConsultation',
            'pending',
            'confirmed',
            'completed',
            'cancelled'
        ));
    }
}