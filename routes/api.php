<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\{MajorController, GradeController, StudentController, TeacherController};
use App\Http\Controllers\{
    InternshipPlaceController,InternshipPlacementController,InternshipSubmissionController,InternshipSubmissionStatusController,InternshipCertificateController, InternshipReportController,InternshipReportStatusController
};
use App\Http\Controllers\{
    LogbookController,LogbookStatusController,AttendanceController,PeriodController, PeriodStatusController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which                        
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return response()->json([
        'message' => 'Authenticated.',
        'data'    => $request->user(),
    ], 200);
});


Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->group(function (){
    
    Route::post('/logout',                      [AuthController::class, 'logout']);

    //master
    //Route::resource('/levels',                 LevelController::class);
    Route::resource('/majors',                  MajorController::class);
    Route::resource('/grades',                  GradeController::class);
    Route::get('/students/user/{userId?}',      [StudentController::class,'getFullDataUser']);   
    Route::resource('/students',                StudentController::class);   
    Route::get('/teachers/user/{userId?}',      [TeacherController::class,'getFullDataUser']);   
    Route::resource('/teachers',                TeacherController::class);

    //internship
    Route::resource('/periods',                 PeriodController::class);
    Route::resource('/period-statuses',         PeriodStatusController::class);
    Route::resource('/places',                  InternshipPlaceController::class);
    // Route::resource('/submissions',             InternshipSubmissionController::class);    
    Route::get('/submissions',                  [InternshipSubmissionController::class, 'index']);    
    Route::post('/submissions',                 [InternshipSubmissionController::class, 'store']);    
    Route::put('/submissions/{id?}',            [InternshipSubmissionController::class, 'update']);    
    Route::delete('/submissions/{id?}',         [InternshipSubmissionController::class, 'destroy']);    
    Route::get('/submissions/{id?}/edit',       [InternshipSubmissionController::class, 'edit']);    
    Route::resource('/submissions-statuses',    InternshipSubmissionStatusController::class);    
    Route::resource('/internship-placements',   InternshipPlacementController::class);
    Route::resource('/attendances',             AttendanceController::class);
    Route::resource('/logbooks',                LogbookController::class);
    Route::resource('/logbook-statuses',        LogbookStatusController::class);
    Route::get('/certificates',                  [InternshipCertificateController::class, 'index']);    
    Route::post('/certificates',                 [InternshipCertificateController::class, 'store']);    
    Route::put('/certificates/{id?}',            [InternshipCertificateController::class, 'update']);    
    Route::get('/certificates/{id?}/edit',       [InternshipCertificateController::class, 'edit']);  
    Route::delete('/certificates/{id?}',         [InternshipCertificateController::class, 'destroy']); 
    
    Route::resource('/reports',                InternshipReportController::class);
    Route::resource('/report-statuses',        InternshipReportStatusController::class);
});

