<?php

namespace App\Console\Commands;

use App\Models\DonHang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class AutoCompleteShippingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-complete-shipping-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $orders = DonHang::where('trang_thai', 'shipping')
            ->where('ngay_giao_hang', '<', now()->subDays(5))
            ->get();

        foreach ($orders as $order) {
            $order->update([
                'trang_thai' => 'completed',
                'ngay_hoan_thanh' => now()
            ]);
        }
    }
}
