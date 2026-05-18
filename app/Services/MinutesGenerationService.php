<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Meeting;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;

class MinutesGenerationService
{
    /**
     * Generate a legally binding Meeting Minutes PDF in Arabic (RTL).
     */
    public function generateMinutes(Meeting $meeting): string
    {
        $meeting->load(['committee', 'agendaItems', 'committee.members']);

        $html = View::make('pdf.minutes', [
            'meeting' => $meeting,
            'date' => now()->format('Y-m-d'),
        ])->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 15,
            'default_font' => 'dejavusanscondensed',
            'direction' => 'rtl',
        ]);

        $mpdf->SetDirectionality('rtl');
        $mpdf->WriteHTML($html);

        return $mpdf->Output('', 'S'); // Return as string to handle as needed
    }
}
