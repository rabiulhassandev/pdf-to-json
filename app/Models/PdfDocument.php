<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PdfDocument extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'file_path',
        'original_filename',
        'mime_type',
        'file_size',
    ];

    /**
     * Relationship to customer.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relationship to extraction result.
     */
    public function extractionResult(): HasOne
    {
        return $this->hasOne(ExtractionResult::class);
    }
}
