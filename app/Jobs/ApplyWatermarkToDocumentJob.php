<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use setasign\Fpdi\Fpdi;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ApplyWatermarkToDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Media $media,
        protected string $userName,
        protected string $ipAddress
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $originalPath = $this->media->getPath();
        $watermarkedPath = storage_path("app/private/watermarked_{$this->media->id}.pdf");

        $pdf = new Fpdi;
        $pageCount = $pdf->setSourceFile($originalPath);

        $watermarkText = "{$this->userName} | {$this->ipAddress} | ".now()->toDateTimeString();

        for ($i = 1; $i <= $pageCount; $i++) {
            $templateId = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($templateId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            // Set font and color (light gray with transparency if supported by library extensions, otherwise light gray)
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->SetTextColor(200, 200, 200);

            // Draw diagonal watermark
            $pdf->RotatedText(20, $size['height'] - 20, $watermarkText, 45);
        }

        $pdf->Output('F', $watermarkedPath);

        // Logic to link watermarkedPath to the session for temporary viewing would go here
    }
}

/**
 * FPDI doesn't have native rotation, so we extend it in-line or via a trait if needed.
 * For this micro-task, we'll assume a standard Fpdi implementation or utility.
 */
class FpdiExtended extends Fpdi
{
    public function RotatedText($x, $y, $txt, $angle)
    {
        // Text rotated around its origin
        $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm BT /F%d %.2F Tf (%s) Tj ET Q',
            cos(deg2rad($angle)), sin(deg2rad($angle)), -sin(deg2rad($angle)), cos(deg2rad($angle)), $x, $y, -$x, -$y, $this->FontFamily, $this->FontSizePt, $this->_escape($txt)));
    }
}
