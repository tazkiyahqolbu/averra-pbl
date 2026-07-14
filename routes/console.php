<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('reminder:pengembalian')->dailyAt('08:00');
Schedule::command('pemesanan:auto-cancel')->everyFiveMinutes();
Schedule::command('sewa:update-status')->dailyAt('00:01');
