<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Services\PdfProcessorService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\PdfToText\Pdf;

class DocumentProcessor extends Component
{
    use WithFileUploads;

    public $customers;
    public $selectedCustomerId;
    public $pdfFile;
    public $extractedText;
    public $jsonResponse;
    public $processing = false;
    public $error;

    public function mount()
    {
        $this->customers = Customer::all();
    }

    public function render()
    {
        return view('livewire.document-processor');
    }

    public function processDocument(PdfProcessorService $pdfProcessor)
    {
        $this->validate([
            'selectedCustomerId' => 'required|exists:customers,id',
            'pdfFile' => 'required|file|mimes:pdf|max:10240', // 10MB Max
        ]);

        $this->processing = true;
        $this->error = null;
        $this->extractedText = null;
        $this->jsonResponse = null;

        dd(Pdf::getText('book.pdf'));

        try {
            $customer = Customer::find($this->selectedCustomerId);
            $path = $this->pdfFile->store('pdfs', 'private');

            $result = $pdfProcessor->process($path, $customer);

            $this->extractedText = $result['text'];
            $this->jsonResponse = $result['json'];

        } catch (\Exception $e) {
            $this->error = 'An error occurred: ' . $e->getMessage();
        } finally {
            $this->processing = false;
        }
    }
}
