<?php

namespace App\Http\Controllers;

use App\Models\InternshipReport;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Period;
use App\Models\InternshipPlacement;
use App\Http\Requests\InternshipReportRequest;
use App\Http\Requests\InternshipReportStudentRequest;
use App\Http\Requests\UpdateInternshipReportRequest;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class InternshipReportController extends Controller
{
    public function index()
    {
        if (auth()->user()->level_id == 1) {
            $internshipReports = InternshipReport::with('student','teacher','status')->orderBy('status_id')->get();
        } else if (auth()->user()->level_id == 2 || auth()->user()->level_id == 3) {
            $internshipReports = InternshipReport::with('student','teacher','status')->where('teacher_id', $this->getTeacher()->id)->orderBy('status_id')->get();
        } else if (auth()->user()->level_id == 5) {
            $internshipReports = InternshipReport::with('student','teacher','status')->where('student_id', $this->getStudent()->id)->orderBy('status_id')->get();
        }
        return response()->json([
            "success"              => true,
            'internshipReports'    => $internshipReports,
        ], 200);
    }

    public function store(InternshipReportRequest $request)
    {
        $data = $request->validated();
        $placement = InternshipPlacement::where('student_id', $data['student_id'])->first();
        // dd($placement);
        $cekReport = InternshipReport::where('student_id', $data['student_id'])->first();
        $period = Period::find($placement->period_id);

        if($placement == null){
            return response()->json([
                'success' => false,
                'message' => 'Siswa belum melaksanakan PKL',
             ], 400);
        }

        if (Carbon::now() < Carbon::parse($period->start_date)){
            return response()->json([
                'success' => false,
                'message' => 'Periode PKL belum dimulai, tanggal mulai : '. $period->start_date,
                ], 400);
        }else if(Carbon::now() < Carbon::parse($period->end_date)){
            return response()->json([
                'success' => false,
                'message' => 'Periode PKL telah berakhir, tanggal berakhir : '. $period->end_date,
                ], 400);
        }

        $data['internship_placement_id'] = $placement->id;
        $data['teacher_id'] = $placement->teacher_id;
        $data['status_id'] = '1';

        if ($cekReport != null && $cekReport->status_id == 1) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan PKL belum ditinjau!',
             ], 400);
        }else if ($cekReport != null && $cekReport->status_id == 2){
            return response()->json([
                'success' => false,
                'message' => 'Laporan PKL telah diterima!',
             ], 400);
        }else if ($cekReport != null && $cekReport->status_id == 3){
            if($request->file('file')){
                File::delete($cekReport->file);
                $path = 'storage/report';
                $file = $request->file('file');
                $file_name = time() . str_replace(" ", "", $file->getClientOriginalName());
                $file->move($path, $file_name);
                $data['file'] = $path.'/'.$file_name;

                $cekReport->update($data);
                if($cekReport){
                    return response()->json([
                        'success'=> true,
                        'message' => "Laporan PKL berhasil diperbarui"
                    ],200);
                }
            }
        }else{
            if($request->file('file')){
                $path = 'storage/report';
                $file = $request->file('file');
                $file_name = time() . str_replace(" ", "", $file->getClientOriginalName());
                $file->move($path, $file_name);
                $data['file'] = $path.'/'.$file_name;

                $internshipReport = InternshipReport::create($data);
                if($internshipReport){
                    return response()->json([
                        'success'=> true,
                        'message' => "Laporan PKL berhasil ditambahkan"
                    ],200);
                }
            }
        }
    }

    public function show(InternshipReport $internshipReport)
    {
        $internshipReport->load('student','teacher','status')->get();
        return response()->json([
            'success' => true,
            'internshipReport' => $internshipReport
        ],200);
    }

    public function edit($id)
    {
        $internshipReport = InternshipReport::find($id);   
        if (auth()->user()->level_id == 2 ) {
            if ($internshipReport->teacher_id == $this->getTeacher()->id) {
                return response()->json([
                    'success' => true,
                    'internshipReport' => $internshipReport
                ],200);
            } else {
                return response()->json([
                    'success' => false,
                ],200);
            }
        } else {
            return response()->json([
                'success' => true,
                'report' => $internshipReport
            ],200);
        }

    }

    public function update(UpdateInternshipReportRequest $request, $id)
    {
        $internshipReport = InternshipReport::find($id);
        $data = $request->all();
        $internshipReport->update($data);

        if($internshipReport){
            return response()->json([
                'success'=> true,
                'message' => "Laporan PKL berhasil diperbarui"
            ],200);
        }
    }

    public function destroy($id)
    {
        $internshipReport = InternshipReport::find($id);
        File::delete($internshipReport->file);
        $internshipReport->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus!'
        ],200);
    }

    public function storeForStudent(InternshipReportStudentRequest $request)
    {
        $data = $request->validated();
        $placement = InternshipPlacement::where('student_id', $this->getStudent()->id)->first();
        $cekReport = InternshipReport::where('student_id', $this->getStudent()->id)->first();
        $period = Period::find($placement->period_id);

        if($placement == null){
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melaksanakan PKL!',
             ], 400);
        }

        if (Carbon::now() < Carbon::parse($period->start_date)){
            return response()->json([
                'success' => false,
                'message' => 'Periode PKL belum dimulai, tanggal mulai : '. $period->start_date,
                ], 400);
        }else if(Carbon::now() < Carbon::parse($period->end_date)){
            return response()->json([
                'success' => false,
                'message' => 'Periode PKL belum berakhir, tanggal berakhir : '. $period->end_date,
                ], 400);
        }

        $data['internship_placement_id'] = $placement->id;
        $data['student_id'] = $placement->student_id;
        $data['teacher_id'] = $placement->teacher_id;
        $data['status_id'] = '1';

        if ($cekReport != null && $cekReport->status_id == 1) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan PKL belum ditinjau!',
             ], 400);
        }else if ($cekReport != null && $cekReport->status_id == 2){
            return response()->json([
                'success' => false,
                'message' => 'Laporan PKL telah diterima!',
             ], 400);
        }else if ($cekReport != null && $cekReport->status_id == 3){
            if($request->file('file')){
                File::delete($cekReport->file);
                $path = 'storage/report';
                $file = $request->file('file');
                $file_name = time() . str_replace(" ", "", $file->getClientOriginalName());
                $file->move($path, $file_name);
                $data['file'] = $path.'/'.$file_name;

                $cekReport->update($data);
                if($cekReport){
                    return response()->json([
                        'success'=> true,
                        'message' => "Laporan PKL berhasil diperbarui"
                    ],200);
                }
            }
        }else{
            if($request->file('file')){
                $path = 'storage/report';
                $file = $request->file('file');
                $file_name = time() . str_replace(" ", "", $file->getClientOriginalName());
                $file->move($path, $file_name);
                $data['file'] = $path.'/'.$file_name;

                $internshipReport = InternshipReport::create($data);
                if($internshipReport){
                    return response()->json([
                        'success'=> true,
                        'message' => "Laporan PKL berhasil ditambahkan"
                    ],200);
                }
            }
        }
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