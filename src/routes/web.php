<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeightLogController;
use App\Http\Controllers\WeightTargetController; // ← 追加

// 新規登録
Route::get('/register/step1', [AuthController::class, 'createStep1'])->name('register.step1.create');
Route::post('/register/step1', [AuthController::class, 'storeStep1'])->name('register.step1.store');

// Step2 は認証後
Route::middleware('auth')->group(function () {
    Route::get('/register/step2', [AuthController::class, 'createStep2'])->name('register.step2.create');
    Route::post('/register/step2', [AuthController::class, 'storeStep2'])->name('register.step2.store');
});

// ▼ 体重管理（認証必須）
Route::middleware('auth')->group(function () {
    // 一覧・検索・作成（モーダル運用で create 画面は未使用）
    Route::get('/weight_logs', [WeightLogController::class, 'index'])->name('weight_logs');
    Route::get('/weight_logs/search', [WeightLogController::class, 'search'])->name('weight_logs.search');
    Route::get('/weight_logs/create', fn() => abort(404)); // 画面は使わない
    Route::post('/weight_logs', [WeightLogController::class, 'store'])->name('weight_logs.store');

    // 更新（画面→実行）
    Route::get('/weight_logs/{weightLog}/update', [WeightLogController::class, 'edit'])->name('weight_logs.edit');
    Route::put('/weight_logs/{weightLog}/update', [WeightLogController::class, 'update'])->name('weight_logs.update');

    // 削除
    Route::delete('/weight_logs/{weightLog}/delete', [WeightLogController::class, 'destroy'])->name('weight_logs.delete');

    
    // 目標設定（typo 修正済み）
    Route::get('/weight_logs/goal_setting', [WeightTargetController::class, 'edit'])->name('goal.edit');
    Route::post('/weight_logs/goal_setting', [WeightTargetController::class, 'update'])->name('goal.update');

    // 詳細
    Route::get('/weight_logs/{weightLog}', [WeightLogController::class, 'show'])
        ->whereNumber('weightLog')
        ->name('weight_logs.show');


    // ログアウト
    Route::post('/logout', function () {
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});
