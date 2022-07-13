<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogbookStatus;

class LogbookStatusController extends Controller
{
    public function index()
    {
        $logbookStatuses = LogbookStatus::all();
        return response()->json([
            'success' => true,
            'logbookStatuses' => $logbookStatuses
        ]);
    }
}
