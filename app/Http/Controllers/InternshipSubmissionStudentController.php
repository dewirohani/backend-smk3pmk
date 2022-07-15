<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternshipSubmission;
use App\Models\InternshipPlacement;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\InternshipPlace;
use App\Http\Requests\SubmissionStudentRequest;
use Illuminate\Support\Facades\File;
use DB;

class InternshipSubmissionStudentController extends Controller
{
    public function index()
    {
        $student = Student::where('user_id', auth()->user()->id)->first();
        $internshipSubmissions = InternshipSubmission::with('internshipSubmissionStatus','student','period','internshipPlace','authorizer')->where('student_id',$student->id)->first();

        return response()->json([
            "success"               => true,
            'internshipSubmissions' => $internshipSubmissions
        ]);
    }

    public function store(SubmissionStudentRequest $request)
    {
        $data = $request->validated();
        $student = Student::where('user_id', auth()->user()->id)->first();
        $cek1 = InternshipSubmission::where('student_id',$student->id)->where('status_id','1')->orderBy('created_at', 'desc')->first();
        $cek2 = InternshipSubmission::where('student_id',$student->id)->where('status_id','2')->orderBy('created_at', 'desc')->first();
        $cek3 = InternshipSubmission::where('student_id',$student->id)->where('status_id','3')->orderBy('created_at', 'desc')->first();

        if ($cek1 != null){
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat membuat pengajuan ulang sebelum pengajuan sebelumnya ditinjau!',
             ], 400);
        } else if ($cek2 != null){
            return response()->json([
                'success' => false,
                'message' => 'Pengajuan sebelumnya telah diterima!',
             ], 400);
        } else if($cek3 != null){
            if($request->file('file')){
                File::delete($cek3->file);
                $path = 'storage/submission';
                $file = $request->file('file');
                $file_name = time() . str_replace(" ", "", $file->getClientOriginalName());
                $file->move($path, $file_name);
                $data['file'] = $path.'/'.$file_name;
                $data['status_id'] = '1';
                $data['student_id'] = $student->id;
                $data['grade_id'] = $student->grade_id;
                $data['major_id'] = $student->major_id;
                $data['authorized_by'] = null;
            }

            $cek3->update($data);

            if($cek3){
                return response()->json([
                    'success'=> true,
                    'message' => "Pengajuan baru berhasil ditambahkan!"
                ],200);
            }
        }else {
            $file = $request->file('file');
            if($request->file('file')){
                $path = 'storage/submission';
                $file = $request->file('file');
                $file_name = time() . str_replace(" ", "", $file->getClientOriginalName());
                $file->move($path, $file_name);
                $data['file'] = $path.'/'.$file_name;
                $data['status_id'] = '1';
                $data['student_id'] = $student->id;
                $data['grade_id'] = $student->grade_id;
                $data['major_id'] = $student->major_id;
            }

            $internshipSubmission = InternshipSubmission::create($data);

            if($internshipSubmission){
                return response()->json([
                    'success'=> true,
                    'message' => "Pengajuan berhasil ditambahkan"
                ],200);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Pengajuan gagal disimpan',
         ], 400);
    }
}