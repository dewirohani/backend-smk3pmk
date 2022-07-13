<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\InternshipSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PeriodRequest;
use File;

class PeriodController extends Controller
{
    public function index()
    {
    $period = Period::with('periodStatuses')->get();
        return response()->json([
            'success'   => true,
            'periods'   => $period
        ]);
    }

    public function create()
    {
        //
    }

    public function store(PeriodRequest $request)
    {
        $data = $request->validated();
        $period = Period::create($data);

        if($period){
            return response()->json([
                'success' => true,
                'message' => "$period->nama_periode Berhasil Ditambahkan"
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => "Gagal Disimpan"
        ], 409);
        
    }

    // public function show(Period $period)
    // {
    //     $periodStatus->load('periodStatuses')->get();
    //     return response()->json([
    //         'success' => true,
    //         'periodStatus' =>$periodStatus
    //     ]);
    // }

    public function edit($id)
    {
        $period = Period::find($id);
        return response()->json([
            'success' => true,
            'period' => $period
        ], 200);
    }

    public function update(PeriodRequest $request, Period $period)
    {
        $data = $request->validated();
        $period->update($data);

        if($period){
            return response()->json([
                'success' => true,
                'message' => "$period->nama_periode Berhasil Diperbarui"
            ], 200);
        }
        return response()->json([
            'success'   => false,
            'message'   => 'Gagagl Diperbarui'
        ], 409);
    }

    public function destroy(Period $period)
    {
        $internshipSubmission = InternshipSubmission::select('file')->where('period_id', $period->id)->get();
        foreach($internshipSubmission as $key){
            if(isset($key->file)){
                File::delete($key->file);
            }
        }
        $period->delete();

        return response()->json([
            'success' => true,
            'message' => "Berhasil Dihapus"
        ], 200);
    }
}
