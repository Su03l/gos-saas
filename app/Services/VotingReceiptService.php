<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Vote;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Storage;

class VotingReceiptService
{
    /**
     * Generate a legally binding PDF receipt for a cast vote.
     */
    public function generateReceipt(Vote $vote): string
    {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 20,
            'margin_right' => 20,
            'margin_top' => 30,
            'margin_bottom' => 20,
        ]);

        $member = $vote->user;
        $resolution = $vote->resolution;
        $timestamp = $vote->created_at->toDateTimeString();
        $ip = request()->ip();
        
        // Generate a cryptographic hash of the vote for integrity verification
        $integrityHash = hash('sha256', implode('|', [
            $vote->id,
            $member->id,
            $resolution->id,
            $vote->type,
            $timestamp,
            $ip
        ]));

        $html = "
            <div style='text-align: center; border-bottom: 2px solid #1e3a8a; padding-bottom: 10px; margin-bottom: 30px;'>
                <h1 style='color: #1e3a8a; margin: 0;'>Electronic Voting Receipt</h1>
                <p style='color: #666;'>Legally Binding Document</p>
            </div>

            <div style='margin-bottom: 20px;'>
                <h3>Member Information</h3>
                <p><strong>Name:</strong> {$member->name}</p>
                <p><strong>Email:</strong> {$member->email}</p>
            </div>

            <div style='margin-bottom: 20px;'>
                <h3>Resolution Details</h3>
                <p><strong>Title:</strong> {$resolution->title}</p>
                <p><strong>Committee:</strong> {$resolution->committee->name}</p>
            </div>

            <div style='margin-bottom: 20px; background-color: #f8fafc; padding: 20px; border-radius: 8px;'>
                <h3>Vote Cast</h3>
                <p style='font-size: 1.2em;'><strong>Decision:</strong> " . strtoupper($vote->type) . "</p>
                <p><strong>Timestamp:</strong> {$timestamp}</p>
                <p><strong>IP Address:</strong> {$ip}</p>
            </div>

            <div style='margin-top: 40px; font-family: monospace; font-size: 0.8em; color: #666;'>
                <p><strong>Integrity Hash (SHA-256):</strong><br>{$integrityHash}</p>
                <p style='margin-top: 10px; font-style: italic;'>This document serves as a permanent record of the electronic vote cast through the Governance SaaS platform.</p>
            </div>
        ";

        $mpdf->WriteHTML($html);

        $fileName = "receipts/vote_{$vote->id}.pdf";
        $pdfContent = $mpdf->Output('', 'S');
        
        Storage::disk('private')->put($fileName, $pdfContent);

        return $fileName;
    }
}
