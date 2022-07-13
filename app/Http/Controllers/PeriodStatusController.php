<?php

namespace App\Http\Controllers;

use App\Models\PeriodStatus;
use Illuminate\Http\Request;

class PeriodStatusController extends Controller
{
    public function index()
    {
        $periodStatuses = PeriodStatus::all();
        return response()->json([
            'success' => true,
            'periodStatuses' => $periodStatuses
        ]);
    }
}
