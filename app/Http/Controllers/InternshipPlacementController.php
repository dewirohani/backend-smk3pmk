<?php

namespace App\Http\Controllers;

use App\Models\InternshipPlacement;
use Illuminate\Http\Request;
use App\Models\InternshipSubmission;
use App\Models\InternshipPlace;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Logbook;
use App\Http\Requests\InternshipPlacementRequest;
use DB;
use File;

class InternshipPlacementController extends Controller
{
    public function index()
    {
        $internshipPlacements = InternshipPlacement::with('internshipSubmission','student','period','internshipPlace','teacher','grade','major')->orderBy('updated_at','DESC')->get();
        return response()->json([
            "success"               => true,
            'internshipPlacements' => $internshipPlacements
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validated();
        $internshipPlace = InternshipPLace::where('id',$data['internship_place_id'])->first();
        $studentData = Student::select('grade_id','major_id')->where('id',$data['student_id'])->first();
        $prevSubmission = InternshipSubmission::where('student_id', $data['student_id'])->first();
        $prevPlace = InternshipPLace::where('id', $prevSubmission->internship_place_id)->first();

        DB::beginTransaction();
            try {
                if(isset($prevSubmission)){
                    DB::beginTransaction();
                    try {
                        File::delete($prevSubmission->file);
                        $prevSubmission->delete();
                        $prevPlace->update([
                            'quota' => $prevPlace->quota + 1,
                        ]);
                        DB::commit();
                    } catch (\Throwable $th) {
                        DB::rollback();
                        return response()->json([
                            'success' => false,
                            'message' => 'Ada kesalahan saat melakukan pengajuan sebelumnya',
                        ], 400);
                    }
                }
                if($request->file('file')){
                    $path = 'storage/submission';
                    $file = $request->file('file');
                    $file_name = time() . str_replace(" ", "", $file->getClientOriginalName());
                    $file->move($path, $file_name);
                    $data['file'] = $path.'/'.$file_name;
                    $data['status_id'] = '2';
                    $data['grade_id'] = $studentData->grade_id;
                    $data['major_id'] = $studentData->major_id;
                    $data['authorized_by'] = $this->getTeacher()->id;
                }

                $internshipSubmission = InternshipSubmission::create($data);

                $internshipPlacement = InternshipPlacement::create([
                    'internship_submission_id' => $internshipSubmission->id,
                    'student_id'               => $internshipSubmission->student_id,
                    'period_id'                => $internshipSubmission->period_id,
                    'internship_place_id'      => $internshipSubmission->internship_place_id,
                    'teacher_id'               => $company->teacher_id,
                    'grade_id'                 => $studentData->grade_id,
                    'major_id'                 => $studentData->major_id,

                ]);

                $internshipPlace->update([
                    'quota' => $internshipPlace->quota - 1,
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => "Penempatan berhasil ditambahkan!"
                ],200);

            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Penempatan gagal ditambahkan',
                 ], 400);
            }
    }

    
    public function destroy(InternshipPlacement $internshipPlacement)
    {
        $internshipPlace = InternshipPlace::where('id',$internshipPlacement->internship_place_id)->first();
        $internshipSubmission = InternshipSubmission::find($internshipPlacement->internship_submission_id);
        DB::beginTransaction();
        try {
                $internshipPlacement->delete();

                $Logbooks = Logbook::select('file')->where('student_id', $internshipSubmission->student_id)->get();
                foreach ($Logbooks as $key) {
                    if (isset($key->file)) {
                        File::delete($key->file);
                    }
                }

                Attendance::where('student_id', $internshipSubmission->student_id)->delete();

                $internshipPlace->update([
                    'quota' => $internshipPlace->quota + 1,
                ]);

                $internshipSubmission->update([
                    'status_id' => 3,
                    'authorized_by' => $this->getTeacher()->id,
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => "Penempatan berhasil dihapus!"
                ],200);

            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Penempatan gagal dihapus!',
                 ], 409);
        }
    }
    
    private function getTeacher()
    {
        $teacher = Teacher::where('user_id', auth()->user()->id)->first();
        return $teacher;
    }
}
