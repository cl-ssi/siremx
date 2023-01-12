<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClaveUnicaController;


Route::post('/authenticate/login','Auth\LoginController@login');
Route::get('/authenticate/logincu/{access_token}','Auth\LoginController@logincu');

// Route::get('/claveunica/login','ClaveUnicaController@login');
Route::get('/claveunica', [ClaveUnicaController::class,'autenticar'])->name('claveunica.login');
Route::get('/claveunica/callback', [ClaveUnicaController::class,'callback']);
Route::get('/logout', [ClaveUnicaController::class,'logout'])->name('claveunica.logout');

//Route::get('/logincu/{access_token}','Auth\LoginController@logincu');

Route::group(['middleware' => ['auth']], function () {
  
  Route::post('/authenticate/logout','Auth\LoginController@logout')->name('logout');
  Route::post('/claveunica/logout', [ClaveUnicaController::class,'logout'])->name('logout-local');

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

  Route::get('/administracion/derivations/getListDerivations','Management\DerivationController@getListDerivations');
  Route::get('/administracion/derivations/getListDerivationsSelect','Management\DerivationController@getListDerivationsSelect');

  Route::post('/archivo/setRegistrarArchivo','FileController@setRegistrarArchivo');

  Route::get('/administracion/patient/getListarPatients','PatientController@getListarPatients');
  Route::get('/administracion/patient/getPatientById','PatientController@getPatientById');
  Route::post('/administracion/patient/setStorePatient','PatientController@setStorePatient');
  Route::get('/administracion/patient/getPatient','PatientController@getPatient');
  Route::get('/administracion/patient/showPatient','PatientController@showPatient');
  Route::post('/administracion/patient/setEditPatient','PatientController@setEditPatient');

  Route::get('/exam/getExamById','Exam\ExamController@getExamById');
  Route::get('/exam/downloadExamById/{exam}','Exam\ExamController@downloadExamById');
  Route::get('/exam/getListExams','Exam\ExamController@getListExams');
  Route::post('/exam/setStoreExam','Exam\ExamController@setStoreExam');
  Route::post('/exam/setLoadExams','Exam\ExamController@setLoadExams');
  Route::post('/exam/setLoadSigteID','Exam\ExamController@setLoadSigteID');
  Route::post('/exam/setEditExam','Exam\ExamController@setEditExam');
  Route::post('/exam/setDeleteExam','Exam\ExamController@setDeleteExam');

  Route::get('/load/getListLoads','Management\LoadController@getListLoads');
  Route::post('/load/setDeleteLoad','Management\LoadController@setDeleteLoad');

  Route::get('/report/exams/getPatientHistoryClinical','Report\ReportController@getPatientHistoryClinical');
  Route::get('/report/exams/getPatientHistory','Report\ReportController@getPatientHistory');
  Route::get('/report/exams/getMX','Report\ReportController@getMX');
  Route::get('/report/exams/getMXCoverage','Report\ReportController@getMXCoverage');
  Route::get('/report/exams/getBirardsAgeMX','Report\ReportController@getBirardsAgeMX');
  Route::get('/report/exams/getBirardsEcoAgeMX','Report\ReportController@getBirardsEcoAgeMX');
  Route::get('/report/exam/export','Report\ReportController@export');
  Route::get('/report/exams/getMXBirards','Report\ReportController@getMXBirards'); 
  Route::get('/report/exams/getMXBiradYears','Report\ReportController@getMXBiradYears');
  Route::get('/report/exams/getMXSigte','Report\ReportController@getMXSigte'); 

  Route::get('/dashboard/getExamYear','DashboardController@getExamYear');
  Route::get('/dashboard/getHistYear','DashboardController@getHistYear');
  Route::get('/dashboard/getHistEstablishmentYear','DashboardController@getHistEstablishmentYear');
  Route::get('/dashboard/getIndicators','DashboardController@getIndicators');
  Route::get('/dashboard/getIndicator5069','DashboardController@getIndicator5069');
  Route::get('/dashboard/getIndicatorBirads','DashboardController@getIndicatorBirads');
  Route::get('/dashboard/getExamBiradsYear','DashboardController@getExamBiradsYear');
  Route::get('/dashboard/getHistEstablishmentYearProfessional','DashboardController@getHistEstablishmentYearProfessional');

  // DASHBOARD AUDITORIA

  Route::get('/dashboard/getExamYearEstablishment','DashboardController@getExamYearEstablishment');
  Route::get('/dashboard/getLastExamEstablishment','DashboardController@getLastExamEstablishment');

}); // END MIDDLEWARE



Route::get('/{optional?}', function () {
    return view('app');
})->name('basepath')
  ->where('optional', '.*');

