<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use App\Console\Commands\AutoCompleteShippingOrders;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        AutoCompleteShippingOrders::class,
    ];
    protected function schedule(Schedule $schedule): void
    {
        
        $schedule->call(function () {
            \Log::info('✅ Laravel scheduler đã chạy lúc: ' . now());
        })->everyMinute(); // 👈 Quan trọng: phải có để test
        $schedule->command(AutoCompleteShippingOrders::class)->daily(); // 👈 Tự động hoàn thành đơn hàng đã giao sau 5 ngày
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        
    }
}
