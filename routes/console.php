<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Clean up expired OTPs daily
Schedule::call(function () {
    \App\Models\PasswordResetOtp::where('expires_at', '<', now()->subDay())->delete();
})->daily();
