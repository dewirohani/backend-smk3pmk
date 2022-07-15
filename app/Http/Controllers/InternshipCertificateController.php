<?php

namespace App\Http\Controllers;

use App\Models\InternshipCertificate;
use App\Models\InternshipPlacement;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Http\Requests\InternshipCertificateRequest;
use App\Http\Requests\UpdateCertificateRequest;
use DB;
use Illuminate\Support\Facades\File;
use Image;

class InternshipCertificateController extends Controller
{

    public function index()
    {
        $certificate = InternshipCertificate::with('student','teacher')->get();
        return response()->json([
            'success' => true,
            'internship_certificate' => $certificate
        ]);
    }

    public function create()
    {
        //
    }

    public function store(InternshipCertificateRequest $request)
    {
        $data = $request->validated();
        $teacherData = InternshipPlacement::select('teacher_id')->where('student_id',$data['student_id'])->first();
        // dd($teacherData);
        $data['file'] = null;
        if($request->file('file')){
            $path = 'storage/sertifikat';
            $file = $request->file('file');
            $file_name = time() . str_replace(" ", "", $file->getClientOriginalName());
            $imageFile = Image::make($file->getRealPath());
            $imageFile->resize(800, 800, function ($constraint) {
            $constraint->aspectRatio();
            })->save($path.'/'.$file_name,80);
            $data['file'] = $path.'/'.$file_name;
        }
     
        $certificate = InternshipCertificate::create([
            'student_id'               => $data['student_id'],
            'teacher_id'               => $teacherData->teacher_id,
            'file'                     => $data['file'],
        ]);

        if($certificate){
            return response()->json([
                'success'=> true,
                'message' => "Sertifikat berhasil ditambahkan"
            ],200);
        }


    }
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $internshipCertificate = InternshipCertificate::find($id);
        return response()->json([
            "success"     => true,
            'certificates'     => $internshipCertificate
        ], 200);
    }

    public function update(UpdateCertificateRequest $request, $id)
    {
        // dd($data);
        $internshipCertificate = InternshipCertificate::find($id);
        $data = $request->validated();
        $file = $request->file('file');
        if($file){
            File::delete($internshipCertificate->file);
            $path = 'storage/sertifikat';
            $file = $request->file('file');
            $file_name = time() . str_replace(" ", "", $file->getClientOriginalName());
            $file->move($path, $file_name);
            $data['file'] = $path.'/'.$file_name;
            
        }

        $internshipCertificate->update($data);

        if($internshipCertificate){
            return response()->json([
                'success'=> true,
                'message' => "Sertifikat berhasil diperbarui!"
            ],200);
        }

    }

    public function destroy($id)
    
    {
        $internshipCertificate = InternshipCertificate::find($id);
        File::delete($internshipCertificate->file);
        $internshipCertificate->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus!'
        ],200);
    }
}
