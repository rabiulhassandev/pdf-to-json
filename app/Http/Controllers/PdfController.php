<?php

namespace App\Http\Controllers;

use App\Ai\DocumentAgent;
use Illuminate\Support\Facades\Http;
use Imagick;
use Laravel\Ai\Files\Document;
use Spatie\PdfToText\Pdf;

class PdfController extends Controller
{
    public function pdfToImage()
    {
        $pdfPath = public_path('pdf/sample.pdf');
        $outputPath = public_path('images/');

        // Ensure the output directory exists
        if (!file_exists($outputPath)) {
            mkdir($outputPath, 0755, true);
        }

        // Use Imagick to convert PDF to images
        try {
            $imagick = new Imagick();
            $imagick->readImage($pdfPath);

            foreach ($imagick as $index => $page) {
                $page->setImageFormat('jpg');
                $page->writeImage($outputPath . 'page_' . ($index + 1) . '.jpg');
            }

            return response()->json(['message' => 'PDF converted to images successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to convert PDF: ' . $e->getMessage()], 500);
        }
    }


    // encode pdf to base64
    public function encodePdfToBase64()
    {
        $pdfPath = public_path('pdf/sample.pdf');

        try {
            $pdfContent = file_get_contents($pdfPath);
            $base64Encoded = base64_encode($pdfContent);

            return response()->json(['base64' => $base64Encoded]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to encode PDF: ' . $e->getMessage()], 500);
        }
    }


    // pdf analyzer
    public function pdfAnalyzer()
    {
        // pdf analyzer by GLM API (Send the pdf directly to the API and get the analysis result)
        $pdfPath = public_path('pdf/sample.pdf');
        $token = '3eb2dc17d8c64a63a34f675ca7df7f83.O2FMtVwaqhf2I4Lf';

        $pdfText = Pdf::getText($pdfPath, '/usr/bin/pdftotext');

        dd($pdfText);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->attach(
            'file',
            fopen($pdfPath, 'r'),
            'sample.pdf'
        )->post('https://open.bigmodel.cn/api/paas/v4/files');

        dd($response->json());

        // $response = Http::withHeaders([
        //     'Authorization' => 'Bearer ' . $token,
        // ])->post('https://open.bigmodel.cn/api/paas/v4/chat/completions', [
        //     'model' => 'glm-4',
        //     'messages' => [
        //         [
        //             'role' => 'user',
        //             'content' => [
        //                 [
        //                     'type' => 'file',
        //                     'file_id' => $fileId
        //                 ],
        //                 [
        //                     'type' => 'text',
        //                     'text' => 'Find the person information in the following PDF content and list them separately.'
        //                 ]
        //             ]
        //         ]
        //     ]
        // ]);

        // return response()->json($response->json());
        
    }

    public function analyzePdfWithOpenRouter()
    {
        $response = (new DocumentAgent)->prompt(
        'Find the person information in the following PDF content and list them separately.',
        provider: env('AI_DEFAULT_PROVIDER', 'openrouter'),
        attachments: [
                Document::fromPath(public_path('sample.pdf')),
            ]
        );

        return response()->json(['text' => $response->text]);
    }

}
