<?php

declare(strict_types=1);

namespace App\Ai;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;
use Stringable;

final class DocumentAgent implements Agent
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'You are a document analysis assistant. Carefully read the provided documents or files and answer the user\'s questions accurately based on their content.';
    }
}