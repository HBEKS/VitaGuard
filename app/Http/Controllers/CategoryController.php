<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allCategories = Category::all();
        return view('categories.index', compact('allCategories'));
    }

    public function showExpensiveService()
    {
        // Ambil semua kategori beserta relasi services-nya
        $categories = Category::with('services')->get();

        // Proses data untuk mendapatkan service termahal di setiap kategori
        $result = [];

        foreach ($categories as $category) {
            // Cari service termahal di kategori ini
            $mostExpensiveService = $category->services()
                ->orderBy('price', 'desc')
                ->first();

            $result[] = [
                'category_id' => $category->id,
                'category_name' => $category->category_name,
                'service_name' => $mostExpensiveService ? $mostExpensiveService->service_name : '-',
                'price' => $mostExpensiveService ? $mostExpensiveService->price : null,
                'description' => $mostExpensiveService ? $mostExpensiveService->description : '-',
                'availability' => $mostExpensiveService ? $mostExpensiveService->availability : '-',
            ];
        }

        return view('categories.expensiveservice', ['categories' => $result]);
    }

    public function showInfo()
    {
        // Ambil semua kategori dengan jumlah services
        $categories = Category::withCount('services')->get();

        // Cari jumlah services tertinggi
        $maxServices = $categories->max('services_count');

        // Jika tidak ada data atau maxServices = 0
        if (!$maxServices || $maxServices == 0) {
            return response()->json([
                'status' => 'warning',
                'msg' => '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Tidak ada data!</strong> Belum ada kategori yang memiliki layanan.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>'
            ]);
        }

        // Ambil semua kategori dengan jumlah services = maxServices
        $topCategories = $categories->filter(function ($category) use ($maxServices) {
            return $category->services_count == $maxServices;
        });

        // Buat daftar nama kategori
        $categoryNames = $topCategories->pluck('category_name')->implode(', ');

        // Jika hanya 1 kategori
        if ($topCategories->count() == 1) {
            $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-trophy me-2"></i>
            <strong>Kategori dengan Layanan Terbanyak:</strong> ' .
                $categoryNames .
                ' (' . $maxServices . ' layanan).
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';
        }
        // Jika lebih dari 1 kategori (sama-sama terbanyak)
        else {
            $msg = '<div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-share-alt me-2"></i>
            <strong>' . $topCategories->count() . ' Kategori dengan Layanan Terbanyak:</strong><br>
            ' . $categoryNames . '<br>
            <small>Masing-masing memiliki ' . $maxServices . ' layanan.</small>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';
        }

        return response()->json([
            'status' => 'success',
            'msg' => $msg
        ]);
    }

    public function showListServices(Request $request)
    {
        $category = Category::with('services')->find($request->idcat);

        if (!$category) {
            return response()->json(array(
                'status' => 'error',
                'title' => 'Error',
                'body' => '<p class="text-danger">Category not found</p>'
            ), 404);
        }

        $name = $category->category_name;
        $services = $category->services;

        $html = view('categories.showListServices', compact('services'))->render();

        return response()->json(array(
            'status' => 'oke',
            'title' => $name . ' - Service List',
            'body' => $html
        ), 200);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
