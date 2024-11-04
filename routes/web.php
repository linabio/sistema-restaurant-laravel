<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\TipoProductoController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\DetallePedidoController;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    return 'Cache cleared and config cached!';
});




// php artisan route:list
Route::get('login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);




Route::middleware(['auth:usuario'])->group(function () {
    Route::get('dashboard', [AuthController::class, 'mostrarDashboard'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('marca', MarcaController::class);
    Route::resource('producto', ProductoController::class);
    Route::resource('empleado', EmpleadoController::class);
    Route::resource('usuario', UsuarioController::class);
    Route::resource('tipo_producto', TipoProductoController::class);
    Route::resource('mesa', MesaController::class);
    Route::resource('pedido', PedidoController::class);
    Route::resource('detallePedido', DetallePedidoController::class);

    Route::get('pedidos/{mesa}', [PedidoController::class, 'index'])->name('pedido.mesa.index');

    Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create');
    // Route::get('mesa/create', [MesaController::class, 'create'])->name('mesa.create');
    Route::get('mesas/create', [MesaController::class, 'create'])->name('mesas.create');
    Route::post('mesas', [MesaController::class, 'store'])->name('mesas.store');
    
    Route::get('/pedidos/{id}/edit', [MarcaController::class, 'edit'])->name('pedidos.edit');

    Route::get('mesa/{mesa}/pedidos', [MesaController::class, 'pedidos'])->name('mesa.pedidos');
});
