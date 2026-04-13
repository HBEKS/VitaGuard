<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SpecializationController extends Controller
{
    public function index()
    {
        $specializations = Specialization::withCount('doctorProfiles')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.specializations.index', compact('specializations'));
    }

    public function create()
    {
        return view('admin.specializations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:specializations,name',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Specialization::create($validated);

        return redirect()->route('admin.specializations.index')
            ->with('success', 'Spesialisasi berhasil ditambahkan.');
    }

    public function show(Specialization $specialization)
    {
        $specialization->load(['doctorProfiles.user']);

        return view('admin.specializations.show', compact('specialization'));
    }

    public function edit(Specialization $specialization)
    {
        return view('admin.specializations.edit', compact('specialization'));
    }

    public function update(Request $request, Specialization $specialization)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:specializations,name,' . $specialization->id,
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $specialization->update($validated);

        return redirect()->route('admin.specializations.index')
            ->with('success', 'Spesialisasi berhasil diperbarui.');
    }

    public function destroy(Specialization $specialization)
    {
        if ($specialization->doctorProfiles()->exists()) {
            return back()->with('error', 'Spesialisasi tidak dapat dihapus karena masih digunakan oleh dokter.');
        }

        $specialization->delete();

        return redirect()->route('admin.specializations.index')
            ->with('success', 'Spesialisasi berhasil dihapus.');
    }
}
