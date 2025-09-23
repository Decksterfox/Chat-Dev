<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('chat.index');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/new', [ChatController::class, 'index'])->name('chat.new');
    Route::get('/chat/{conversation}', [ChatController::class, 'index'])->name('chat.show');
    Route::get('/chat/history', [ChatController::class, 'history'])->name('chat.history');

    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/chat/upload-pdf', [ChatController::class, 'uploadPdf'])->name('chat.upload-pdf');
    Route::delete('/chat/delete/{conversation}', [ChatController::class, 'deleteConversation'])->name('chat.delete');
});
