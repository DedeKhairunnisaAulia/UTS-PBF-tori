<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages())->setStatusCode(422);
        }

        $payload = $validator->validated();

        Category::create([
            'name' => $payload['name'],
        ]);

        return response()->json([
            'msg' => 'Data berhasil di simpan'
        ],201);
    }

    function showAll() {
        $category = category::all();

        return response()->json([
            'msg' => 'Data keseluruhan',
            'data' => $category
        ],200);
    }

    function showById($id) {
        $category = category::where('id',$id)->first();

        if($category) {
            return response()->json([
                'msg' => 'Data dengan ID: '.$id,
                'data' => $category 
            ],200);
        }

        return response()->json([
            'msg' => 'Data dengan ID: '.$id.'tidak ditemukan',
        ],404);
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages())->setStatusCode(422);
        }

        $payload = $validator->validated();

        Category::create([
            'name' => $payload['name'],
        ]);

        return response()->json([
            'msg' => 'Data berhasil di simpan'
        ],201);
    }

    public function delete($id) {
        $category = category::where('id',$id)->get();
        
        if($category) {

            Category::where('id',$id)->delete();

            return response()->json([
                'msg' => 'Data dengan ID: '.$id.'berhasil di hapus',
            ],200);
        }

        return response()->json([
            'msg' => 'Data dengan ID: '.$id.'tidak ditemukan',
        ],404);

    }

}
