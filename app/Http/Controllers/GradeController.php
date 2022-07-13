<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\GradeRequest;
use DB;


class GradeController extends Controller
{

    public function index()
    {
        $grade = Grade::join('majors','majors.id','=','grades.major_id')
                        ->leftjoin('students','grades.id','=','students.grade_id')
                        ->selectRaw('grades.*, majors.name AS major, COUNT(students.id) AS total_students')
                        ->groupBy('grades.id')
                        ->get();
        return response()->json([
            "success" => true,
            'grades' => $grade,
        ]);
    }

    public function store(GradeRequest $request, Grade $grade)
    {
        $data = $request->validated();
        $grade = Grade::create($data);

        if($grade){
            return response()->json([
                "success" => true,
                "message" => "$grade->name Berhasil Ditambah"
            ],200);
        }

        return response()->json([
                "success" => false,
                "message" => "Kelas Gagal Ditambah",
        ],400);
     
    }

    public function show(Grade $grade)
    {
        $grade->load('major')->get();
        return response()->json([
            'success' => true,
            'grade' =>$grade
        ]);
    }

    public function edit(Grade $grade)
    {
        return response()->json([
            "success" => true,
            "grade" => $grade
        ],200);
    }

    public function update(GradeRequest $request, Grade $grade)
    {
        $data   = $request->all();
        $grade->update(
           
            [
                'name' => $data['name'], 
                'major_id' => $data['major_id'], 
                'description' => $data['description'], 
            ]
        );

        if($grade){
            return response()->json([
                "success" => true,
                "message" => "$grade->name Berhasil Diupdate"
            ],200);
        }

        return response()->json([
                "success" => false,
                "message" => "Jurusan Gagal Diupdate",
        ],409);
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        if($grade){
            return response()->json([
                "success" => true,
                "message" => "Kelas Berhasil Dihapus"
            ],200);
        }

        return response()->json([
                "success" => false,
                "message" => "Kelas Gagal Dihapus"
        ], 400);
    }
}
