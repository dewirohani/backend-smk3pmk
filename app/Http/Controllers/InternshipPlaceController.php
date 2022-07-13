<?php

namespace App\Http\Controllers;

use App\Models\InternshipPlace;
use Illuminate\Http\Request;
use App\Http\Requests\InternshipPlaceRequest;

class InternshipPlaceController extends Controller
{
    public function index()
    {
        $internshipPlace = InternshipPlace::with('teacher')->get();
        return response()->json([
            'success' => true,
            'internship_places' => $internshipPlace
        ]);
    }
  
    public function store(InternshipPlaceRequest $request)
    {
        $data = $request->validated();
        $internshipPlace = InternshipPlace::create($data);

        if($internshipPlace){
            return response()->json([
                'success' => true,
                'message' => "$internshipPlace->name Berhasil Ditambahkan"
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => "Gagal Disimpan"
        ], 400);
        
    }

   
    public function show(InternshipPlace $internshipPlace)
    {
        $internshipPlace->load('teacher')->get();
        return response()->json([
            'success' => true,
            'internshipPlace' =>$internshipPlace
        ]);
    }

   
    public function edit($id)
    {
        $place = InternshipPlace::find($id);
        return response()->json([
            'success' => true,
            'place' => $place
        ], 200);
    }

    
    public function update(InternshipPlaceRequest $request, InternshipPlace $internshipPlace)
    {
        $data = $request->validated();
        $internshipPlace->update($data);

        if($internshipPlace){
            return response()->json([
                'success' => true,
                'message' => "$internshipPlace->name berhasil diperbarui"
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => "Gagal Diperbarui"
        ], 400);
    }

    public function destroy($id)
    {
        
        $internshipPlace->delete();
        return response()->json([
            'success' => true,
            'message' => "Berhasil Dihapus"
        ], 200);
    }
}
