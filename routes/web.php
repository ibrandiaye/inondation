<?php

use App\Http\Controllers\ArrondissementController;
use App\Http\Controllers\CommuneController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaliteController;
use App\Http\Controllers\OperateurController;
use App\Http\Controllers\PersonneController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [HomeController::class,'index'])->middleware(['auth']);
/* Route::get('/', function () {
    return view('home');
})->middleware(['auth']); */


Route::resource('region', RegionController::class)->middleware(['auth']);
Route::resource('departement', DepartementController::class)->middleware(['auth']);
Route::resource('arrondissement', ArrondissementController::class)->middleware(['auth']);
Route::resource('commune', CommuneController::class)->middleware(['auth']);
Route::resource('user', UserController::class)->middleware(['auth','admin']);
Route::resource('operateur', OperateurController::class)->middleware(['auth']);
Route::resource('personne', PersonneController::class)->middleware(['auth']);
Route::resource('localite', LocaliteController::class)->middleware(['auth']);

Route::get('/modifier/motdepasse',[UserController::class,'modifierMotDePasse'])->name("modifier.motdepasse")->middleware(['auth']);
Route::post('/importer/region',[RegionController::class,'importExcel'])->name("importer.region")->middleware(['auth']);//->middleware(['auth', 'admin', 'checkMaxSessions']);

Route::post('/importer/departement',[DepartementController::class,'importExcel'])->name("importer.departement")->middleware(['auth']);//->middleware(['auth', 'admin', 'checkMaxSessions']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth']);
Route::get('/modifier/motdepasse',[UserController::class,'modifierMotDePasse'])->name("modifier.motdepasse")->middleware(['auth']);//->middleware(['auth', 'checkMaxSessions']);
Route::post('/update/password',[UserController::class,'updatePassword'])->name("user.password.update")->middleware(['auth']);//->middleware(["auth","checkMaxSessions"]);
Route::post('/importer/commune',[CommuneController::class,'importExcel'])->name("importer.commune")->middleware("auth");
Route::post('/importer/arrondissement',[ArrondissementController::class,'importExcel'])->name("importer.arrondissement")->middleware("auth");

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth']);
Route::get('/departement/by/region/{region}',[DepartementController::class,'byRegion'])->name('rts.national.departement')->middleware("auth");


Route::get('/commune/by/departement/{departement}',[CommuneController::class,'byDepartement'])->name('rts.national.departement')->middleware("auth");

Route::get('/commune/by/arrondissement/{arrondissement}',[CommuneController::class,'getByArrondissement'])->name('rts.national.departement')->middleware("auth");
Route::get('/arrondissement/by/departement/{departement}',[ArrondissementController::class,'getByDepartement'])->name('rts.national.departement')->middleware("auth");

Route::get('/stat/by/commune/{commune}',[HomeController::class,'statByCommune'])->middleware("auth");


Route::get('/api/by/departement/{id}',[HomeController::class,'byDepartement'])->name('rts.national.departement')->middleware("auth");
Route::get('/api/by/commune/{id}',[HomeController::class,'byCommune'])->name('rts.national.departement')->middleware("auth");

Route::get('/api/by/arrondissement/{id}',[HomeController::class,'byArrondissement'])->name('rts.national.departement')->middleware("auth");
Route::get('/api/by/region/{id}',[HomeController::class,'byRegion'])->name('rts.national.departement')->middleware("auth");

Route::get('/test', function () {
    return view('situation.par_arrondissement');
})->middleware(['auth']);







Route::get('/statbydepartement',[HomeController::class,'statByDepartement'])->name('stat.by.departement')->middleware("auth","admin");


Route::get('/api/by/departement/{id}',[HomeController::class,'byDepartement'])->name('rts.national.departement')->middleware("auth");
Route::get('/api/by/commune/{id}',[HomeController::class,'byCommune'])->name('rts.national.departement')->middleware("auth");

Route::get('/api/by/arrondissement/{id}',[HomeController::class,'byArrondissement'])->name('rts.national.departement')->middleware("auth");
Route::get('/api/by/region/{id}',[HomeController::class,'byRegion'])->name('rts.national.departement')->middleware("auth");


Route::get('/ajouter/personne/{localite}',[PersonneController::class,'createWithLocalite'])->name('ajouter.personne')->middleware("auth");
Route::get('/ajouter/operateur/{localite}',[OperateurController::class,'createWithLocalite'])->name('ajouter.operateur')->middleware("auth");


Route::post('/message/arrondissement',[HomeController::class,'messageByArrondissement'])->name('message.arrondissement')->middleware("auth");

Route::post('/message/departement',[HomeController::class,'messageByDepartement'])->name('message.departement')->middleware("auth");

Route::post('/message/region',[HomeController::class,'messageByRegion'])->name('message.region')->middleware("auth");

Route::post('/message/national',[HomeController::class,'messageByNational'])->name('message.national')->middleware("auth");
