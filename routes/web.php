<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/administracion/usuario/getListarUsuarios','Management\UsersController@getListarUsuarios');
Route::post('/administracion/usuario/setRegistrarUsuario','Management\UsersController@setRegistrarUsuario');
 
Route::get('/administracion/role/getListRoles','Management\RoleController@getListRoles');
Route::post('/administracion/role/setStoreRolePermissions','Management\RoleController@setStoreRolePermissions');
Route::post('/administracion/role/setEditRolePermissions','Management\RoleController@setEditRolePermissions');

Route::get('/administracion/role/getListPermissionsByRole','Management\RoleController@getListPermissionsByRole');

Route::post('/archivo/setRegistrarArchivo','FileController@setRegistrarArchivo');

Route::get('/administracion/patient/getListarPatients','PatientController@getListarPatients');
Route::post('/administracion/patient/setStorePatient','PatientController@setStorePatient');
Route::get('/administracion/patient/getPatient','PatientController@getPatient');
Route::get('/administracion/patient/showPatient','PatientController@showPatient');

Route::get('/exam/getListExams','Exam\ExamController@getListExams');
Route::post('/exam/setLoadExams','Exam\ExamController@setLoadExams');

Route::get('/{optional?}', function () {
    return view('app');
})->name('basepath')
  ->where('optional', '.*');