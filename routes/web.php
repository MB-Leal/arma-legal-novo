<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PedidoArmaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ModeloArmaController;
use App\Http\Controllers\Admin\PedidoController as AdminPedidoController;
use App\Http\Controllers\Admin\LoginController as AdminAuthController;
use App\Http\Controllers\Admin\AssociadoController;

// --- ROTAS PÚBLICAS ---
Route::get('/', [AuthController::class, 'showAcesso'])->name('acesso.index');
Route::post('/validar-associado', [AuthController::class, 'validarAssociado'])->name('acesso.validar');
Route::post('/logout-associado', [AuthController::class, 'logout'])->name('acesso.logout');

// --- ÁREA DO ASSOCIADO (Protegida) ---
Route::middleware(['auth.associado'])->group(function () {
    Route::get('/catalogo', [PedidoArmaController::class, 'vitrine'])->name('associado.catalogo');
    Route::get('/meu-pedido', [PedidoArmaController::class, 'meusPedidos'])->name('associado.pedido');
    Route::get('/pedido/{id}/pdf', [PedidoArmaController::class, 'gerarRequerimento'])->name('associado.pdf');

    // ROTA DO SIMULADOR
    Route::get('/simulador/{id}', [PedidoArmaController::class, 'showSimulador'])->name('associado.simulador');

    // ROTA DE COMPRA
    Route::post('/finalizar-intencao', [PedidoArmaController::class, 'finalizarPedido'])->name('associado.comprar');

    // Dentro do grupo middleware 'auth.associado'
    Route::post('/conferir-dados', [PedidoArmaController::class, 'conferirDados'])->name('associado.conferir');
    Route::post('/processar-pedido', [PedidoArmaController::class, 'finalizarPedido'])->name('associado.processar');
});

// --- ÁREA ADMINISTRATIVA ---
Route::get('/admin', [AdminAuthController::class, 'index']);

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['auth', 'is.admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Gestão de Arsenal
    Route::resource('modelos', ModeloArmaController::class);

    // Gestão de Militares (Associados)
    Route::resource('associados', AssociadoController::class);

    // Gestão de Pedidos/Requerimentos
    Route::resource('pedidos', AdminPedidoController::class);
    Route::post('/pedidos/{id}/aprovar', [AdminPedidoController::class, 'aprovar'])->name('admin.pedidos.aprovar');
    Route::post('/pedidos/{id}/arquivar', [AdminPedidoController::class, 'arquivar'])->name('admin.pedidos.arquivar');
    Route::post('/pedidos/{id}/atualizar-serie', [AdminPedidoController::class, 'updateSerie'])->name('admin.pedidos.updateSerie');
});
