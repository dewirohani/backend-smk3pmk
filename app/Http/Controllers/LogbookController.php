<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Teacher;
use App\Models\Student;
use App\Http\Requests\LogbookRequest;
use App\Http\Requests\LogbookStudentRequest;
use App\Http\Requests\UpdateLogbookRequest;
use Illuminate\Support\Facades\File;
use Image;

class LogbookController extends Controller
{
   
    public function index()
    {
        $logbooks = Logbook::with('attendance','student','teacher','logbookStatuses')->orderBy('date_of_logbook')->get();
        // if (auth()->user()->level_id == 1) {
        //     $logbooks = Logbook::with('attendance','student','teacher','logbookStatuses')->orderBy('date_of_logbook')->get();
        // } else if (auth()->user()->level_id == 2 ) {
        //     $logbooks = Logbook::with('attendance','student','teacher','logbookStatuses')->where('teacher_id', $this->getTeacher()->id)->orderBy('date_of_logbook')->get();
        // } else if (auth()->user()->level_id == 3) {
        //     $logbooks = Logbook::with('attendance','student','teacher','logbookStatuses')->where('student_id', $this->getStudent()->id)->orderBy('date_of_logbook')->get();
        // }

        return response()->json([
            "success"      => true,
            'logbooks'    => $logbooks,
        ], 200);
    }

    
    public function create()
    {
        //
    }

    public function store(LogbookRequest $request)
    {
        $data = $request->validated();
        $cekLogbooks = Logbook::where('date_of_logbook',  $data['date_of_logbook'])->where('student_id', $data['student_id'])->first();
        if (isset($cekLogbooks)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda berhasil mengisi logbook',
            ], 400);
        }

        $attendanceInfo = Attendance::select('id','teacher_id')->where('date', $data['date'])->where('student_id', $data['student_id'])->first();
        if(!isset($attendanceInfo)){
            return response()->json([
                'success' => false,
                'message' => 'Absensi tidak ditemukan, tidak dapat mengisi logbook!',
            ], 400);
        }
        $data['file'] = null;
        if($request->file('file')){
            $path = 'storage/logbook';
            $file = $request->file('file');
            $file_name = time() . str_replace(" ", "", $file->getClientOriginalName());
            $imageFile = Image::make($file->getRealPath());
            $imageFile->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path.'/'.$file_name,80);
            $data['file'] = $path.'/'.$file_name;
        }

        $logbook = Logbook::create([
            'attendance_id'            => $AttendanceInfo->id,
            'student_id'               => $data['student_id'],
            'teacher_id'               => $AttendanceInfo->teacher_id,
            'date_of_logbook'          => $data['date'],
            'status_id'                => 1,
            'file'                     => $data['file'],
            'activity'                 => $data['activity'],
        ]);

        if($logbook){
            return response()->json([
                'success'=> true,
                'message' => "Logbook berhasil ditambahkan"
            ],200);
        }
    }

    public function show(Logbook $logbook)
    {
        $logbook->load('student','teacher','logbookStatuses')->get();
        return response()->json([
            "success"               => true,
            'logbook'     => $logbook
        ], 200);
    }

    public function edit(Logbook $logbook)
    {
        return response()->json([
            "success"     => true,
            'logbook'     => $logbook
        ], 200);
    }

    public function update(UpdateLogbookRequest $request, Logbook $logbook)
    {
        $data = $request->validated();
        $logbook->update($data);

        if($logbook){
            return response()->json([
                'success' => true,
                'message' => "Logbook berhasil diperbarui!"
            ],200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal diperbarui!',
         ], 409);

    }

    public function destroy(Logbook $logbook)
    {
        File::delete($logbook->file);
        $logbook->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus!'
        ],200);
    }

    public function storeForStudent(LogbookStudentRequest $request)
    {
        $data = $request->validated();
        $student = Student::where('user_id', auth()->user()->id)->first();
        $cekLogbooks = Logbook::where('date_of_logbook',  $data['date_of_logbook'])->where('student_id', $student->id)->first();
        if (isset($cekLogbooks)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah mengisi logbook!',
            ], 409);
        }

        $attendanceInfo = Attendance::select('id','teacher_id')->where('date_of_logbook', $data['date_of_logbook'])->where('student_id', $student->id)->first();
        if(!isset($attendanceInfo)){
            return response()->json([
                'success' => false,
                'message' => 'Absensi tidak ditemukan, tidak dapat mengisi logbook!',
            ], 409);
        }

        $data['file'] = null;
        if($request->file('file')){
            $path = 'storage/logbook';
            $file = $request->file('file');
            $file_name = time() . str_replace(" ", "", $file->getClientOriginalName());
            $imageFile = Image::make($file->getRealPath());
            $imageFile->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path.'/'.$file_name,80);
            $data['file'] = $path.'/'.$file_name;
        }

        $logbook = Logbook::create([
            'attendance_id' => $attendanceInfo->id,
            'student_id'               => $student->id,
            'teacher_id'               => $internshipAttendanceInfo->teacher_id,
            'date_of_logbook'                     => $data['date_of_logbook'],
            'status_id'                => 1,
            'file'                     => $data['file'],
            'activity'                 => $data['activity'],
        ]);

        if($logbook){
            return response()->json([
                'success'=> true,
                'message' => "Logbook berhasil ditambahkan"
            ],200);
        }

    }

    public function approveAll()
    {
        $logbook =Logbook::where('teacher_id', $this->getTeacher()->id)->update([
                                'status_id' => 2,
                            ]);

        if($logbook){
            return response()->json([
                'success' => true,
                'message' => "Logbook berhasil diperbarui!"
            ],200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data gagal diperbarui!',
         ], 409);
    }

    private function getTeacher()
    {
        $teacher = Teacher::where('user_id', auth()->user()->id)->first();
        return $teacher;
    }

    private function getStudent()
    {
        $student = Student::where('user_id', auth()->user()->id)->first();
        return $student;
    }
}
