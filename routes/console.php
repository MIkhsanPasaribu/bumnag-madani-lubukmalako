<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Auto-prune error logs yang lebih dari 30 hari
Schedule::command('model:prune', ['--model' => \App\Models\ErrorLog::class])->daily();
