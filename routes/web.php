<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Publico\ChamadoController as PublicoChamadoController;

Route::get('/', [PublicoChamadoController::class, 'index'])->name('chamados.index');

Route::get('/suporte/criar', [PublicoChamadoController::class, 'create'])->name('suporte.create');

Route::post('/suporte', [PublicoChamadoController::class, 'store'])->name('suporte.store');

Route::get('/suporte/{chamado}/{token}', [PublicoChamadoController::class, 'show'])->name('suporte.show');

Route::delete('/suporte/{chamado}/{token}', [PublicoChamadoController::class, 'destroy'])->name('suporte.destroy');

Route::get('/suporte/{chamado}/{token}/edit', [PublicoChamadoController::class, 'edit'])->name('suporte.edit');

Route::put('/suporte/{chamado}/{token}', [PublicoChamadoController::class, 'update'])->name('suporte.update');