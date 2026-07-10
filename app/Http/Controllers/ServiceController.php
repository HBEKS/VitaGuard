<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request()->get('per_page', 10);
        $services = Service::with('category')->paginate($perPage)->withQueryString();
        $categories = Category::all();
        return view('services.index', compact('services', 'categories'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('services.create', compact('categories'));
    }
    public function getEditFormB(Request $request)
    {
        $data = Service::with('category')->find($request->id);
        $categories = Category::all();
        return response()->json([
            'status' => 'oke',
            'msg' => view('services.getEditFormB', compact('data', 'categories'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $data = Service::find($request->id);
        $data->service_name = $request->service_name;
        $data->description  = $request->description;
        $data->availability = $request->availability;
        $data->price        = $request->price;
        $data->category_id  = $request->category_id;
        $data->save();
        return response()->json(['status' => 'oke', 'msg' => 'service updated'], 200);
    }
    public function deleteData(Request $request)
    {
        $data = Service::find($request->id);
        $data->delete();
        return response()->json(['status' => 'oke', 'msg' => 'service deleted'], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Service::create([
            'category_id'  => $request->category_id,
            'service_name' => $request->service_name,
            'description'  => $request->description,
            'availability' => $request->availability,
            'price'        => $request->price,
        ]);
        return redirect()->route('services.index')->with('success', 'Successfully created service.');
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
