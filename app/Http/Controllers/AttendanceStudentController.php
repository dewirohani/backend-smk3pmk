<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\InternshipPlacement;
use App\Models\InternshipPlace;
use App\Models\Student;

class AttendanceStudentController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('student','teacher')->where('student_id', $this->getStudent()->id)->get();

        return response()->json([
            "success"        => true,
            'attendances'    => $attendances
        ], 200);
    }

    public function store(AttendanceRequest $request)
    {
        $data = $request->validated();
        $placement = InternshipPlacement::where('student_id', $data['student_id'])->first();
        if ($placement == null) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum terdaftar di Penempatan PKL',
                ], 400);
        }
        $place = InternshipPlace::where('id',$placement->internship_place_id)->first();    
        $isAvailable = Attendance::where('student_id', $data['student_id'])->where('date', $data['date'])->first();
        
            if (isset($isAvailable)) {
                $updateAttendance = Attendance::updateOrCreate(
                    [
                    'date'       => $data['date'],
                    'student_id' => $data['student_id']
                    ],
                    [
                    'teacher_id'    => $placement->teacher_id,
                    'time_in'       => $data['time_in'],
                    'time_out'      => $data['time_out'],                 
                    'description'    => "-",
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
                    'teacher_id'    => $placement->teacher_id,
                    'date'          => $data['date'],
                    'time_in'       => $data['time_in'],
                    'time_out'      => $data['time_out'],                    
                ]);

                if ($attendance) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Absensi berhasil ditambahkan!',
                        ], 200);
                }
            }      
    }


    private function getStudent()
    {
        $student = Student::where('user_id', auth()->user()->id)->first();
        return $student;
    }
}