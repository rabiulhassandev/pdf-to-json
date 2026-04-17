<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'extraction_notes',
    ];

    /**
     * Relationship to PDF documents.
     */
    public function pdfDocuments(): HasMany
    {
        return $this->hasMany(PdfDocument::class);
    }
}
