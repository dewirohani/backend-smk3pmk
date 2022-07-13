<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternshipSubmissionStatus;

class InternshipSubmissionStatusController extends Controller
{
    public function index()
    {
        $internshipSubmissionStatus = InternshipSubmissionStatus::all();
        return response()->json([
            'success' => true,
            'internshipSubmissionStatus' => $internshipSubmissionStatus
        ]);
    }
}
