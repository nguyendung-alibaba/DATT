<?php

namespace App\Services;

use App\Models\UserBehaviorLog;
use App\Models\SanPham;
use Illuminate\Support\Facades\Auth;

class RecommendationService
{
    public function getRecommendedProducts($limit = 5)
    {
        $user = Auth::user();
        $sessionId = session()->getId();

        // Lấy các sản phẩm đã xem
        $viewed = UserBehaviorLog::where(function ($q) use ($user, $sessionId) {
            if ($user) {
                $q->where('user_id', $user->id);
            } else {
                $q->where('session_id', $sessionId);
            }
        })
        ->where('action', 'view')
        ->pluck('product_id')
        ->toArray();

        // Tìm user khác cũng đã xem các sản phẩm này
        $relatedUsers = UserBehaviorLog::whereIn('product_id', $viewed)
            ->where('action', 'view')
            ->whereNotNull('user_id')
            ->pluck('user_id');

        // Từ các user đó, lấy những sản phẩm họ xem nhưng mình chưa xem
        $suggestedIds = UserBehaviorLog::whereIn('user_id', $relatedUsers)
            ->where('action', 'view')
            ->whereNotIn('product_id', $viewed)
            ->select('product_id')
            ->groupBy('product_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit($limit)
            ->pluck('product_id');

        return SanPham::whereIn('id', $suggestedIds)->get();
    }
}
