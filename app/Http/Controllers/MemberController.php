<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::where('role', 'member')->orderBy('name')->get();
        return view('member.index', compact('members'));
    }

    public function store(Request $request)
    {
        $data = new User();
        $data->name     = $request->name;
        $data->email    = $request->email;
        $data->password = Hash::make($request->password);
        $data->role     = 'member';
        $data->save();
        return redirect()->route('members.index')->with('success', 'Member added!');
    }

    public function getEditFormB(Request $request)
    {
        $data = User::find($request->id);
        return response()->json([
            'status' => 'oke',
            'msg' => view('member.getEditFormB', compact('data'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $data = User::find($request->id);
        $data->name  = $request->name;
        $data->email = $request->email;
        if ($request->password) {
            $data->password = Hash::make($request->password);
        }
        $data->save();
        return response()->json(['status' => 'oke', 'msg' => 'Member updated!'], 200);
    }

    public function deleteData(Request $request)
    {
        $data = User::find($request->id);
        $data->delete();
        return response()->json(['status' => 'oke', 'msg' => 'Member deleted!'], 200);
    }

    public function create() {}
    public function show($id) {}
    public function edit($id) {}
    public function update(Request $request, $id) {}
    public function destroy($id) {}
}