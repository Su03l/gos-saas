<?php

declare(strict_types=1);

use App\Jobs\CheckOverdueTasksJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new CheckOverdueTasksJob)->daily();

Schedule::command('app:purge-old-data')->monthly();
