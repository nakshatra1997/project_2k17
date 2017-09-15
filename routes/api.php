<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

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
    return $request->user();
});
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('recover', 'AuthController@recover');
Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'AuthController@logout');
});
//TO DOWNLOAD SAMPLE SYNOPSIS*******************************************************************************
Route::get('downloadsynopsis', function()
{
    $path = storage_path().'/'.'app'.'/'.'public'.'/'.'samplesynopsis'.'/'.'Synopsis.pdf';
    if (file_exists($path)) {
        return Response::download($path);
    }
});
//*****************************************************************************************************
//avoid camel casing in routes names,it was creating error(getDomains=>getdomains)
Route::get('/getdomains','DomainController@index');
Route::get('/getdomains/{id}/topics','DomainController@specificTopic');
Route::get('/checkstudentno/{student_no}','CheckStudentController@checkStudentNo');
Route::post('/checkemail','CheckStudentController@checkEmail');
