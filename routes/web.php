<?php

use Illuminate\Support\Facades\Route;

Route::post('/authenticate/login','Auth\LoginController@login');

Route::group(['middleware' => ['auth']], function () {
  
  Route::post('/authenticate/logout','Auth\LoginController@logout');

  Route::get('/administracion/user/getListRolePermissionsByUser','Management\UsersController@getListRolePermissionsByUser');
  Route::get('/administracion/usuario/getListarUsuarios','Management\UsersController@getListarUsuarios');
  Route::post('/administracion/usuario/setRegistrarUsuario','Management\UsersController@setRegistrarUsuario');
  Route::post('/administracion/usuario/setEditUser','Management\UsersController@setEditUser');
  Route::post('/administracion/user/setChangeUserState','Management\UsersController@setChangeUserState');
  Route::post('/administracion/user/setEditRoleByUser','Management\UsersController@setEditRoleByUser');
  Route::get('/administracion/user/getRolByUser','Management\UsersController@getRolByUser');
  Route::get('/administracion/user/getListPermissionByRoleAssigned','Management\UsersController@getListPermissionByRoleAssigned');
  Route::get('/administracion/user/getListPermissionsByUser','Management\UsersController@getListPermissionsByUser');
  Route::post('/administracion/user/setStoreRolePermissionsByUser','Management\UsersController@setStoreRolePermissionsByUser');
  
  Route::get('/administracion/role/getListRoles','Management\RoleController@getListRoles');
  Route::post('/administracion/role/setStoreRolePermissions','Management\RoleController@setStoreRolePermissions');
  Route::post('/administracion/role/setEditRolePermissions','Management\RoleController@setEditRolePermissions');
  Route::get('/administracion/role/getListPermissionsByRole','Management\RoleController@getListPermissionsByRole');

  Route::get('/administracion/permission/getlistPermissions','Management\PermissionController@getlistPermissions');
  Route::post('/administracion/permission/setStorePermission','Management\PermissionController@setStorePermission');
  Route::post('/administracion/permission/setEditPermission','Management\PermissionController@setEditPermission');

  Route::get('/administracion/communes/getListCommunes','Management\CommuneController@getListCommunes');

  Route::get('/administracion/establishments/getListEstablishments','Management\EstablishmentController@getListEstablishments');

  Route::post('/archivo/setRegistrarArchivo','FileController@setRegistrarArchivo');

  Route::get('/administracion/patient/getListarPatients','PatientController@getListarPatients');
  Route::post('/administracion/patient/setStorePatient','PatientController@setStorePatient');
  Route::get('/administracion/patient/getPatient','PatientController@getPatient');
  Route::get('/administracion/patient/showPatient','PatientController@showPatient');

  Route::get('/exam/getListExams','Exam\ExamController@getListExams');
  Route::post('/exam/setStoreExam','Exam\ExamController@setStoreExam');
  Route::post('/exam/setLoadExams','Exam\ExamController@setLoadExams');

  Route::get('/report/exams/getPatientHistory','Report\ReportController@getPatientHistory');
  Route::get('/report/exams/getMX','Report\ReportController@getMX');
  Route::get('/report/exams/getBirardsAgeMX','Report\ReportController@getBirardsAgeMX');
  Route::get('/report/exams/getBirardsEcoAgeMX','Report\ReportController@getBirardsEcoAgeMX');
  Route::get('/report/exam/export','Report\ReportController@export');
  Route::get('/report/exams/getMXBirards','Report\ReportController@getMXBirards');

}); // END MIDDLEWARE



Route::get('/sismam/{optional?}', function () {
    return view('app');
})->name('basepath')
  ->where('optional', '.*');

