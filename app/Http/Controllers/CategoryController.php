<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 5);
        $allCategories = Category::with('services')->paginate($perPage)->withQueryString();
        return view('categories.index', compact('allCategories'));
    }

    public function getEditFormB(Request $request)
    {
        $id = $request->id;
        $data = Category::find($id);
        return response()->json([
            'status' => 'oke',
            'msg' => view('categories.getEditFormB', compact('data'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $data = Category::find($request->id);
        $data->category_name = $request->name;
        $data->save();
        return response()->json(['status' => 'oke', 'msg' => 'category data is up-to-date!'], 200);
    }

    public function deleteData(Request $request)
    {
        $data = Category::find($request->id);
        $data->delete();
        return response()->json(['status' => 'oke', 'msg' => 'category data is removed!'], 200);
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
            return response()->json([
                'status' => 'error',
                'title' => 'Error',
                'body' => '<div class="alert alert-danger">Category not found</div>'
            ]);
        }

        $name = $category->category_name;
        $services = $category->services;

        $html = view('categories.showListServices', compact('services'))->render();

        return response()->json([
            'status' => 'oke',
            'title' => $name . ' - Service List',
            'body' => $html
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Category();
        $data->category_name = $request->get('name');
        $data->image = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = strtolower(str_replace(' ', '_', $request->name)) . '.' . $file->extension();
            $data->image = $file->storeAs('img/categories', $filename, 'public');
        }
        $data->save();
        return redirect()->route('categories.index')->with('success', 'Successfully created data.');
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
    public function destroy(Category $category)
    {
        try {
            if ($category->image) {
                $path = storage_path('app/public/' . $category->image);
                if (file_exists($path)) unlink($path);
            }
            $category->delete();
            return redirect()->route('categories.index')->with('success', 'Successfully deleted.');
        } catch (\PDOException $ex) {
            return redirect()->route('categories.index')->with('status', 'Make sure no related data.');
        }
    }
}