<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\PdfDocument;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToText\Pdf;
use Laravel\Ai\Ai;

class PdfProcessorService
{
    public function __construct()
    {
        // Ensure pdftotext binary is available
        $binaryPath = config('pdf-to-text.pdftotext');
        if (! file_exists($binaryPath)) {
            throw new \Exception("pdftotext binary not found at {$binaryPath}. Please install Poppler and configure the path in config/pdf-to-text.php");
        }
    }

    public function process(string $filePath, Customer $customer): array
    {
        // 1. Store PDF meta-data
        $pdfDocument = $customer->pdfDocuments()->create([
            'file_path' => $filePath,
            'original_filename' => basename($filePath),
            'file_size' => Storage::disk('private')->size($filePath),
        ]);

        // 2. Extract text from PDF
        $fullPath = Storage::disk('private')->path($filePath);
        $text = (new Pdf())->setPdf($fullPath)->text();

        // 3. Prepare prompt for Gemini
        $prompt = $this->preparePrompt($text, $customer);

        // 4. Call Gemini API
        $aiResponse = Ai::gemini()->json($prompt);

        // 5. Store results
        $pdfDocument->extractionResult()->create([
            'extracted_text' => $text,
            'ai_response' => $aiResponse,
            'status' => 'completed',
        ]);

        return [
            'text' => $text,
            'json' => $aiResponse,
        ];
    }

    private function preparePrompt(string $text, Customer $customer): string
    {
        $rules = $customer->extraction_notes ?: 'Extract key information from the document.';

        return <<<PROMPT
Analyze this text for customer: {$customer->name}.
Rules: {$rules}.
Return results in structured JSON.

--- TEXT ---
{$text}
PROMPT;
    }
}
