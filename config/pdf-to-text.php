<?php

return [
    /*
     * The path to the pdftotext binary.
     * You can download it from https://poppler.freedesktop.org/
     */
    'pdftotext' => env('PDF_TO_TEXT_PATH', '/usr/bin/pdftotext'),

    /*
     * The options to pass to the pdftotext binary.
     */
    'options' => [],
];
