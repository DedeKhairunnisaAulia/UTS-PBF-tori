<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Products;

class ProductsController extends Controller
{
    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'expired_at' => 'required|date',
            'modified_by' => 'required|string|max:255|email',
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages())->setStatusCode(422);
        }

        $payload = $validator->validated();

        Products::create([
            'name' => $payload['name'],
            'description' => $payload['description'],
            'price' => $payload['price'],
            'image' => $payload['image'],
            'category_id' => $payload['category_id'],
            'expired_at' => $payload['expired_at'],
            'modified_by' => $payload['modified_by'],
        ]);

        return response()->json([
            'msg' => 'Data berhasil di simpan'
        ],201);
    }

    function showAll(){
        $products = Products::all();

        return response()->json([
            'msg' => 'Data keseluruhan',
            'data' => $products
        ],200);
    }

    function showById($id) {
        $products = Products::where('id',$id)->first();

        if($products) {
            return response()->json([
                'msg' => 'Data dengan ID: '.$id,
                'data' => $products
            ],200);
        }

        return response()->json([
            'msg' => 'Data dengan ID: '.$id.'tidak ditemukan',
        ],404);
    }

    public function update(Request $request,$id) {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'expired_at' => 'required|date',
            'modified_by' => 'required|string|max:255|email',
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages())->setStatusCode(422);
        }

        $payload = $validator->validated();

        Products::create([
            'name' => $payload['name'],
            'description' => $payload['description'],
            'price' => $payload['price'],
            'image' => $payload['image'],
            'category_id' => $payload['category_id'],
            'expired_at' => $payload['expired_at'],
            'modified_by' => $payload['modified_by'],
        ]);

        return response()->json([
            'msg' => 'Data berhasil di ubah'
        ],201);
    }

    public function delete($id) {
        $products = Products::where('id',$id)->get();
        
        if($products) {

            Products::where('id',$id)->delete();

            return response()->json([
                'msg' => 'Data denganID: '.$id.'berhasil di hapus',
            ],200);
        }

        return response()->json([
            'msg' => 'Data dengan ID: '.$id.'tidak ditemukan',
        ],404);

    }
}
