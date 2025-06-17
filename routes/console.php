<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('app:send-daily-sales-report')->dailyAt('08:00');
// Wajib Konfigurasi Cronjob
// * * * * * cd /path/ke/proyek/anda && php artisan schedule:run >> /dev/null 2>&1
