<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternshipReportStatus;

class InternshipReportStatusController extends Controller
{
    public function index()
    {
        $internshipReportStatuses = InternshipReportStatus::all();

        return response()->json([
            "success"   => true,
            'internshipReportStatuses' => $internshipReportStatuses
        ]);
    }
}
