<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExtractionResult extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'pdf_document_id',
        'extracted_text',
        'ai_response',
        'status',
        'error_message',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'ai_response' => 'array',
    ];

    /**
     * Relationship to PDF document.
     */
    public function pdfDocument(): BelongsTo
    {
        return $this->belongsTo(PdfDocument::class);
    }
}
