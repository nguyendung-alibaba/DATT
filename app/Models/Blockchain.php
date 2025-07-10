<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Blockchain extends Model
{

    use HasFactory;
    protected $fillable = ['don_hang_id', 'previous_hash', 'current_hash'];
    // Đặt tên bảng nếu khác với quy tắc mặc định
    protected $table = 'blockchains';

    public static function generateHash($data)
    {
        return hash('sha256', $data);
    }

    public static function createBlock($donHangId)
    {
        $lastBlock = self::latest()->first();
        $previousHash = $lastBlock ? $lastBlock->current_hash : '0';

        $rawData = $donHangId . $previousHash . now();
        $currentHash = self::generateHash($rawData);

        return self::create([
            'don_hang_id' => $donHangId,
            'previous_hash' => $previousHash,
            'current_hash' => $currentHash,
        ]);
    }

    public static function isValidChain($blocks)
    {
        $previousHash = '0';

        foreach ($blocks as $block) {
            $expectedHash = self::generateHash($block->don_hang_id . $previousHash . $block->created_at);
            if ($block->current_hash !== $expectedHash) {
                return false;
            }
            $previousHash = $block->current_hash;
        }

        return true;
    }
}

