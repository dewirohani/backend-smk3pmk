<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Requests\TeacherRequest;
use DB;

class TeacherController extends Controller
{
    
    public function index()
    {
       $teacher = Teacher::with('user')->get();
       return response()->json([
        'success'   => true,
        'teachers'   => $teacher
       ]);
    }

    public function create()
    {
        //
    }


    public function store(TeacherRequest $request)
    {
        $data = $request->validated();        

        DB::beginTransaction();
        try{
            $user = User::create(
                [
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'level_id' => 2,
                ]
                );
            $teacher = Teacher::create(
                [
                    'nip'           => $data['nip'],
                    'name'          => $data['name'],
                    'user_id'       => $user->id,
                ]
            );
            DB::commit();

            return response()->json([
                'success'   => true,
                'message'   => "$teacher->name Berhasil Ditambahkan",
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
        $teacher = Teacher::with('user')->find($id);
        return response()->json([
            'success' => true,
            'teacher' => $teacher
        ]);
    }

    public function edit(Teacher $teacher)
    {
        //
    }

    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    public function destroy(Teacher $teacher)
    {
        DB::beginTransaction();
        try {
            $user = User::find($teacher->user_id);
            $teacher->delete();
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
        $teacher = Teacher::join('users','teachers.user_id','users.id')->where('user_id', $userId)->first(); 
        if ($teacher){
            return response()->json([
                'success'   => true,
                'message'   => $teacher
            ]);
        } else {
            return response()->json([
                'success'   => false,
            ]);
        }
    }

}
