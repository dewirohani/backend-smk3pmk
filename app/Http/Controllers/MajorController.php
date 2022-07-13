<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;
use App\Http\Requests\MajorRequest;


class MajorController extends Controller
{
    
    public function index()
    {
        $major = Major::all();
        return response()->json([
            "success" => true,
            "majors" => $major
        ]);
    
    }

    public function create(Request $request)
    {


    }

    public function store(MajorRequest $request)
    {
        $data   = $request->validated();
        $major = Major::create($data);

        if($major){
            return response()->json([
                "success" => true,
                "message" => "$major->name Berhasil Ditambah"
            ],200);
        }

        return response()->json([
                "success" => false,
                "message" => "Jurusan Gagal Ditambah",
        ],409);

       
    }

    public function show()
    {
    
    }

    public function edit(Major $major)
    {
        return response()->json([
            "success" => true,
            "major" => $major
        ],200);
    }

    
    public function update(Request $request, Major $major)
    { 

        $data   = $request->all();
        $major->updateOrCreate(
            [
                'code' => $data['code'],
            ],
            [
                'name' => $data['name'], 
                'description' => $data['description'], 
            ]
        );

        if($major){
            return response()->json([
                "success" => true,
                "message" => "$major->name Berhasil Diubah"
            ],200);
        }

        return response()->json([
                "success" => false,
                "message" => "Jurusan Gagal Diubah",
        ],400);
    }

    public function destroy(Major $major)
    {
        $major->delete();

        if($major){
            return response()->json([
                "success" => true,
                "message" => "Jurusan Berhasil Dihapus"
            ],200);
        }

        return response()->json([
                "success" => false,
                "message" => "Jurusan Gagal Dihapus"
        ], 409);
    }
}
