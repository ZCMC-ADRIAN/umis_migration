<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Personal Information Controller
Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('info', 'PersonalInfoController@import');
});

//Address Controller
Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('address', 'AddressController@import');
});

//Contact Controller
Route::namespace('App\Http\Controllers')->group(function () {
    Route::post('contact', 'ContactController@import');
});

//Identification Number Controller
Route::namespace('App\Http\Controllers')->group(function () {
    Route::post('identification', 'IdentificationNoController@import');
});

//Employee Profile Controller
Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('profile', 'EmployeeProfileController@import');
});

//References Controller
Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('reference', 'ReferenceController@import');
});

//Issuance Information Controller
Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('issuance', 'IssuanceInfoController@import');
});

//Civil Service Eligibility Controller
Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('cse', 'CivilServiceEligibilityController@import');
});

//Training Controller
Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('training', 'TrainingController@import');
});

//Employment Controller
Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('employment', 'EmploymentController@import');
});

//Family Background Controller
Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('family-background', 'FamilyBackgroundController@import');
});

//Other Information Controller
Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('other-information', 'OtherInfoController@import');
});

//Department Controller
Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('department', 'DepartmentController@import');
});

//Department Group Controller
Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('department-group', 'DepartmentGroupController@import');
});

//Job Positions Controller
Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('positions', 'JobPositionsController@import');
});

//Extract
Route::namespace('App\Http\Controllers')->group(function () {
    Route::post('extract', 'Extract@import');
});