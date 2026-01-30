<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PedidoArmaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ModeloArmaController;
use App\Http\Controllers\Admin\PedidoController as AdminPedidoController;

// --- ROTAS PÚBLICAS ---
// Tela Inicial / Validação
Route::get('/', [AuthController::class, 'showAcesso'])->name('acesso.index');
Route::post('/validar-associado', [AuthController::class, 'validarAssociado'])->name('acesso.validar');
Route::post('/logout-associado', [AuthController::class, 'logout'])->name('acesso.logout');

// --- ÁREA DO ASSOCIADO (Protegida) ---
Route::middleware(['auth.associado'])->group(function () {
    Route::get('/catalogo', [PedidoArmaController::class, 'vitrine'])->name('associado.catalogo');
    Route::get('/catalogo/{id}', [PedidoArmaController::class, 'showDetalhes'])->name('associado.detalhes');
    Route::get('/simulador/{id}', [PedidoArmaController::class, 'showSimulador'])->name('associado.simulador');

    // Rota de confirmação de endereço
    Route::get('/confirmar-dados/{modelo_id}', [PedidoArmaController::class, 'confirmarDados'])->name('associado.confirmar');
    //Route::get('/confirmar/{modelo_id}', [PedidoArmaController::class, 'confirmarDados'])->name('associado.confirmar');
    Route::post('/finalizar-pedido', [PedidoArmaController::class, 'finalizarPedido'])->name('associado.finalizar');

    Route::get('/meu-pedido', [PedidoArmaController::class, 'meuPedido'])->name('associado.pedido');
    // Tela de sucesso
    Route::get('/pedido-concluido/{id}', [PedidoArmaController::class, 'sucesso'])->name('associado.sucesso');
});

// --- ÁREA ADMINISTRATIVA ---
// Aqui usamos 'auth' para garantir que o Marcos/Adriano estejam logados no sistema padrão
Route::middleware(['auth', 'is.admin'])->prefix('admin')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');
    Route::post('/admin/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Rotas de CRUD (Create, Read, Update, Delete)
    Route::resource('modelos', ModeloArmaController::class);
    Route::resource('pedidos', AdminPedidoController::class);

    // Rota específica para atualizar número de série
    Route::post('/pedidos/{id}/atualizar-serie', [AdminPedidoController::class, 'updateSerie'])->name('admin.pedidos.updateSerie');
});
