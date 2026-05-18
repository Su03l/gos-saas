<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatusPageController extends Controller
{
    /**
     * Display the public system status page.
     */
    public function index()
    {
        // Mocking incident data for the enterprise status page
        $incidents = [
            [
                'title' => 'Scheduled Maintenance: Database Optimization',
                'status' => 'resolved',
                'date' => now()->subDays(2)->toFormattedDateString(),
                'description' => 'We successfully completed scheduled database maintenance to improve query performance across all tenant clusters.',
            ],
            [
                'title' => 'Brief Latency in AI Processing',
                'status' => 'resolved',
                'date' => now()->subDays(12)->toFormattedDateString(),
                'description' => 'A small subset of users experienced delays in AI minutes generation. This was traced to a provider timeout and has been resolved.',
            ],
        ];

        $systems = [
            ['name' => 'Core Application API', 'status' => 'operational'],
            ['name' => 'Tenant Isolated Clusters', 'status' => 'operational'],
            ['name' => 'AI Minutes Engine', 'status' => 'operational'],
            ['name' => 'Electronic Voting Service', 'status' => 'operational'],
            ['name' => 'Virtual Data Room Storage', 'status' => 'operational'],
        ];

        return view('central.status', compact('incidents', 'systems'));
    }
}
