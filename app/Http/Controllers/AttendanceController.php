<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\InternshipPlacement;
use App\Models\InternshipPlace;
use App\Models\Teacher;
use App\Models\Student;
use App\Http\Requests\AttendanceRequest;
use Illuminate\Support\Facades\File;

class AttendanceController extends Controller
{
   
    public function index()
    {
        if (auth()->user()->level_id == 1) {
            $attendance = Attendance::with('student','teacher')->orderBy('date')->get();
        } else if (auth()->user()->level_id == 2 ) {
            $attendance = Attendance::with('student','teacher')->orderBy('date')->where('teacher_id', $this->getTeacher()->id)->orderBy('date')->get();
        } else if (auth()->user()->level_id == 3) {
            $attendance = Attendance::with('student','teacher')->orderBy('date')->where('student_id', $this->getStudent()->id)->orderBy('date')->get();
        }

        return response()->json([
            "success"       => true,
            'attendance'    => $attendance
        ], 200);

    }

   
    public function create()
    {
        //
    }

    public function store(AttendanceRequest $request)
    {
        $data = $request->validated();
        $placementInfo = InternshipPlacement::where('student_id', $data['student_id'])->first();
        if ($placementInfo == null) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tersebut belum terdaftar di Penempatan PKL',
                ], 400);
        }
        $period = Period::where('id', $placementInfo->period_id)->first();
        if (Carbon::parse($data['date']) < Carbon::parse($period->start_date)){
            return response()->json([
                'success' => false,
                'message' => 'Periode PKL belum dimulai, tanggal mulai : '. $period->start_date,
                ], 400);
        }else if(Carbon::parse($data['date']) > Carbon::parse($period->end_date)){
            return response()->json([
                'success' => false,
                'message' => 'Periode PKL telah berakhir, tanggal berakhir : '. $period->end_date,
                ], 400);
        }else{
            $place = InternshipPlace::where('id',$placementInfo->internship_place_id)->first();
            
            $isAvailable = Attendance::where('student_id', $data['student_id'])->where('date', $data['date'])->first();
            
                if (isset($isAvailable)) {
                    $updateAttendance = Attendance::updateOrCreate(
                        [
                        'date'       => $data['date'],
                        'student_id' => $data['student_id']
                        ],
                        [
                        'teacher_id'    => $placementInfo->teacher_id,
                        'time_in'       => $data['time_in'],                        
                        'description'   => "-",
                        ]
                    );
                    if ($updateAttendance) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Absensi berhasil diperbarui!',
                            ], 200);
                    }
                }else {
                    $attendance = Attendance::create([
                        'student_id'    => $data['student_id'],
                        'teacher_id'    => $placementInfo->teacher_id,
                        'date'          => $data['date'],
                        'time_in'       => $data['time_in'],
                        'time_out'      => $data['time_out'],                        
                        'description'   => "-",
                    ]);

                    if ($attendance) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Absensi berhasil ditambahkan!',
                            ], 200);
                    }
                }
        }
        }

    public function destroy($id)
    {
        $attendance = Attendance::find($id);
        $attendance->delete();
        return response()->json('Attendance deleted successfully');
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
