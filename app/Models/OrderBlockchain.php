<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderBlockchain extends Model
{
    protected $table = 'order_blockchains';
    protected $primaryKey = 'id';

    protected $fillable = [
        'don_hang_id',
        'data',
        'current_hash',
        'previous_hash',
    ];
      public static function createBlock($donHangId)
    {
        // Lấy đơn hàng hiện tại
        $order = \App\Models\DonHang::findOrFail($donHangId);

        // Lấy block trước đó
        $lastBlock = self::latest()->first();

        $data = json_encode($order->toArray());
        $previousHash = $lastBlock?->current_hash ?? 'GENESIS';

        // Tạo current hash từ dữ liệu và previous hash
        $currentHash = hash('sha256', $data . $previousHash);

        return self::create([

            'don_hang_id' => $donHangId,
            'data' => $data,
            'previous_hash' => $previousHash,
            'current_hash' => $currentHash,
        ]);
    }

    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'don_hang_id');
    }
}
