<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

// 
use App\Http\Controllers\devicesController;
use App\Http\Controllers\EtiquetasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnaliticosController;
use App\Http\Controllers\LineChartController;
//


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

Route::get('/', function () {
    return redirect('login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    // return view('dashboard');
    return redirect()->route(('Dashboard.index'));
})->name('dashboard');




Auth::routes();
Route::get('/Analiticos/Filtrar', [AnaliticosController::class, 'filtrarAnaliticos'])->name('Analiticos.filter');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth']], function() {
    Route::resource('Dashboard', DashboardController::class);
    Route::resource('Devices', devicesController::class);
    Route::resource('roles', RoleController::class);
    
    Route::resource('users', UserController::class);
    // Route::post('/user/invite', [UserController::class, 'invite'])->name('users.invitar');
    Route::post('/line-chart', [LineChartController::class, 'lineChart'])->name('linechart');

    Route::resource('products', ProductController::class);
    Route::resource('Etiquetas', EtiquetasController::class);
    Route::resource('Categorias', CategoriasController::class);
    Route::resource('Analiticos', AnaliticosController::class);
    
    

});
Route::get('/Api/LiftAndLearn/getDevice/{idCategoria}', [ApiController::class, 'getIdDevicesByCategoria']);
Route::get('/Api/LiftAndLearn/getPIN/{idDevice}', [ApiController::class, 'getPinsByIdDevices']);
Route::get('/Api/LiftAndLearn/action/{tipo}/{pin}', [ApiController::class, 'insertActionByPin']);
Route::get('/Api/LiftAndLearn/getDataset/{idCategoria}', [ApiController::class, 'getDatasetByCategoria']);
Route::get('/Api/LiftAndLearn/getAction/{idDevice}', [ApiController::class, 'getActionByDevice']);
Route::get('/Api/LiftAndLearn/soldProduct/{idDevice}', [devicesController::class, 'soldProduct']);
Route::get('/Api/Seemetrix', [ApiController::class, 'Seemetrix']);


