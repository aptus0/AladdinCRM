<?php

namespace App\Actions\Quotes;

use App\Models\Quote;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportQuotePdf
{
    /**
     * @throws \RuntimeException
     */
    public function handle(Quote $quote): BinaryFileResponse
    {
        if (! class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            throw new \RuntimeException('Dompdf package is not installed. Run: composer require barryvdh/laravel-dompdf');
        }

        $quote->load(['items', 'company', 'opportunity']);

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.quote', [
            'quote' => $quote,
        ])->download($quote->quote_number.'.pdf');
    }
}
