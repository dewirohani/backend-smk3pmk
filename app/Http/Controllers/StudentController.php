<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Grade;
use App\Models\Major;
use App\Http\Requests\StudentRequest;
use DB;


class StudentController extends Controller
{

    public function index()
    {
       
    $student = Student::with('user','grade','major')->get();
       
       return response()->json([
        "success"   => true,
        "students"  => $student
       ]);
    }

    public function create()
    {
        //
    }


    public function store(StudentRequest $request)
    {
        $data = $request->validated();
        $grade = Grade::where('id', $data['grade_id'])->first();
        $major = Major::where('id', $grade->major_id)->first();
        
        DB::beginTransaction();
        try{
            $user = User::create(
                [
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'level_id' => 3,
                ]
            );

            $student = Student::create(
                [
                    'nis'           => $data['nis'],
                    'name'          => $data['name'],
                    'grade_id'      => $data['grade_id'],
                    'major_id'      => $major->id,
                    'year_of_entry' => $data['year_of_entry'],
                    'user_id'       => $user->id,
                ]
            );
            DB::commit();

            return response()->json([
                'success'   => true,
                'message'   => "$student->name Berhasil Ditambahkan",
            ], 200);

        } catch (\Exception $exception){
            DB::rollback();
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Ditambahkan',
            ], 400);
        }

    }

    public function show($id)
    {
        $student = Student::with('user','grade','major')->find($id);
        return response()->json([
            'success' => true,
            'student' => $student
        ]);
       
    }

    public function edit(Student $student)
    {
        //
    }

    public function update(Request $request, Student $student)
    {
      
    }
    public function destroy(Student $student)
    {
        DB::beginTransaction();
        try {
            $user = User::find($student->user_id);
            $student->delete();
            $user->delete();
            DB::commit();
            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil Dihapus',
            ], 200);
        } catch (\Exception $exception){
            DB::rollback();
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Dihapus',
            ], 409);
        }
    }

    public function getFullDataUser($userId){
        $student = Student::join('users','students.user_id','users.id')->where('user_id', $userId)->first(); 
        if ($student){
            return response()->json([
                'success'   => true,
                'message'   => $student
            ]);
        } else {
            return response()->json([
                'success'   => false,
            ]);
        }
    }

}
