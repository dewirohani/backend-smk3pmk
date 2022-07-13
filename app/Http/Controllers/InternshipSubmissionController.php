<?php

namespace App\Http\Controllers;

use App\Models\InternshipSubmission;
use App\Models\InternshipSubmissionStatus;
use App\Models\InternshipPlacement;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\InternshipPlace;
use Illuminate\Http\Request;
use App\Http\Requests\InternshipSubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;
use DB;
use Illuminate\Support\Facades\File;

class InternshipSubmissionController extends Controller
{
    public function index()
    {
        $internshipSubmissions = InternshipSubmission::with('student','period','internshipPlace','internshipSubmissionStatus')->orderBy('status_id')->get();
        return response()->json([
            "success"               => true,
            'internshipSubmissions' => $internshipSubmissions
        ]);
    }

    public function create()
    {
        //
    }

    public function store(InternshipSubmissionRequest $request)
    {
        $data = $request->validated();
        $cek1 = InternshipSubmission::where('student_id',$data['student_id'])->where('status_id','1')->orderBy('created_at', 'desc')->first();
        $cek2 = InternshipSubmission::where('student_id',$data['student_id'])->where('status_id','2')->orderBy('created_at', 'desc')->first();
        $cek3 = InternshipSubmission::where('student_id',$data['student_id'])->where('status_id','3')->orderBy('created_at', 'desc')->first();
        $studentData = Student::select('grade_id','major_id')->where('id',$data['student_id'])->first();
        if ($cek1 != null){
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa melakukan pengajuan ulang sebelum pengajuan sebelumnya disetujui!',
             ], 409);
        } else if ($cek2 != null){
            return response()->json([
                'success' => false,
                'message' => 'Pengajuan sebelumnya telah diterima!',
             ], 409);
        } else if($cek3 != null){
            if($request->file('file')){
                File::delete($cek3->file);
                $path = 'storage/submission';
                $file = $request->file('file');
                $file_name = time() . str_replace(" ", "", $file->getClientOriginalName());
                $file->move($path, $file_name);
                $data['file'] = $path.'/'.$file_name;
                $data['status_id'] = '1';
                $data['grade_id'] = $studentData->grade_id;
                $data['major_id'] = $studentData->major_id;
            }
            $cek3->update($data);

            if($cek3){
                return response()->json([
                    'success'=> true,
                    'message' => "Pengajuan berhasil ditambahkan!"
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
                $data['grade_id'] = $studentData->grade_id;
                $data['major_id'] = $studentData->major_id;
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

    public function edit($id)
    {
        $internshipSubmission = InternshipSubmission::find($id);
        return response()->json([
            'success' => true,
            'submission' => $internshipSubmission
        ],200);
    }

    public function update($id, UpdateSubmissionRequest $request)
    {
        $internshipSubmission = InternshipSubmission::find($id);
        $place = InternshipPlace::where('id',$internshipSubmission->internship_place_id)->first();
        $studentData = Student::select('grade_id','major_id')->where('id',$internshipSubmission->student_id)->first();
        $teacher = Teacher::where('user_id', auth()->user()->id)->first();
        // $studentData = Student::;
        // dd(InternshipSubmission::select('internship_place_id')->first);
        $data = $request->validated();
        // dd($data);
        if ($request->status_id == '2') {
                $internshipSubmission->update($data);
                $internshipPlacement = InternshipPlacement::create([
                    'internship_submission_id' => $internshipSubmission->id,
                    'student_id'               => $internshipSubmission->student_id,
                    'period_id'                => $internshipSubmission->period_id,
                    'internship_place_id'      => $internshipSubmission->internship_place_id,
                    'teacher_id'               => $place->teacher_id,
                    'grade_id'                 => $studentData->grade_id,
                    'major_id'                 => $studentData->major_id,
                ]);

                $place->update([
                    'quota' => $place->quota - 1,
                ]);

                $internshipSubmission->update([
                    'authorized_by' => $teacher->id,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => "Pengajuan berhasil diperbarui!"
                ],200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data gagal diperbarui!',
         ], 400);
    }

    public function destroy($id)
    {
        $internshipSubmission = InternshipSubmission::find($id);
        File::delete($internshipSubmission->file);
        $internshipSubmission->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus!'
        ],200);
    }

    private function getTeacher()
    {
        $teacher = Teacher::where('user_id', auth()->user()->id)->first();
        
    }
}
