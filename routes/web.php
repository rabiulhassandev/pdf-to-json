<?php

use App\Ai\DocumentAgent;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Livewire\CustomerManager;
use App\Livewire\DocumentProcessor;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Laravel\Ai\Files\Document;

Route::view('/', 'welcome');

Route::get('/pdf-to-image', [PdfController::class, 'pdfToImage'])->name('pdf.index');
Route::get('/pdf-to-base64', [PdfController::class, 'encodePdfToBase64'])->name('pdf.base64');

// openrouter api test
Route::get('/openrouter-test', function () {
    $response = Http::withHeaders([
        'Authorization' => 'Bearer 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',
    ])->post('https://openrouter.ai/api/v1/chat/completions', [
        'model' => 'z-ai/glm-4.5-air:free',
        'messages' => [
            [
                'role' => 'user',
                'content' => 'Hello, how are you?',
            ],
        ],
    ]);

    dd($response->json());
});


Route::get('/test', function () {

    $response = (new DocumentAgent)->prompt(
        'who are you?',
        provider: env('AI_DEFAULT_PROVIDER', 'openrouter'),
        model: 'z-ai/glm-4.5-air:free'
    );

    return response()->json([
        'text' => $response->text
    ]);

})->name('document.agent.test');

// pdf analyzer 
Route::get('/pdf-analyzer', [PdfController::class, 'pdfAnalyzer'])->name('pdf.analyzer');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('customers', CustomerManager::class)->name('customers');
    Route::get('process-document', DocumentProcessor::class)->name('process.document');
});

require __DIR__.'/auth.php';

