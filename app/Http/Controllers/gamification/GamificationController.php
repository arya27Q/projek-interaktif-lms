<?php

namespace App\Http\Controllers\gamification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gamification\GamificationStat;
use Illuminate\Support\Facades\Auth;

class GamificationController extends Controller
{
    // Mengambil data Klasemen (Top 10)
    public function getLeaderboard(Request $request)
    {
        // Tarik data stat dari DB, urutkan berdasarkan EXP terbanyak
        $stats = GamificationStat::with('user:id,name,avatar')
            ->orderBy('total_exp', 'desc')
            ->take(10)
            ->get();

        // Rapihkan datanya biar gampang dibaca oleh Vue
        $leaderboard = $stats->map(function ($stat) {
            $user = $stat->user;
            return [
                'id' => $user ? $user->id : 0,
                'name' => $user ? $user->name : 'Pengguna',
                'badge' => ucfirst($stat->rank_tier),
                'exp' => $stat->total_exp,
                'avatar' => ($user && $user->avatar) ? $user->avatar : 'https://ui-avatars.com/api/?name=' . urlencode($user ? $user->name : 'P'),
                'trend' => 10, // Angka kenaikan stat (bisa dibikin dinamis nanti)
                'isCurrentUser' => Auth::check() && Auth::id() == $stat->user_id,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $leaderboard
        ]);
    }

    // Mengambil data Streak & Pangkat User
    public function getStreak(Request $request)
    {
        $user = Auth::user();

        // Cari atau buat statistik gamifikasi untuk user ini
        $stat = GamificationStat::firstOrCreate(
            ['user_id' => $user->id],
            ['current_streak' => 0, 'total_exp' => 0, 'rank_tier' => 'Bronze']
        );

        $today = now()->startOfDay();
        $lastLogin = $stat->last_login_date ? \Carbon\Carbon::parse($stat->last_login_date)->startOfDay() : null;

        if (!$lastLogin) {
            $stat->current_streak = 1;
        } elseif ($lastLogin->diffInDays($today) == 1) {
            $stat->current_streak += 1;
        } elseif ($lastLogin->diffInDays($today) > 1) {
            $stat->current_streak = 1; // reset jika lewat sehari
        }
        
        $stat->last_login_date = now();
        $stat->save();

        return response()->json([
            'success' => true,
            'data' => [
                'current_streak' => $stat->current_streak,
                'total_exp' => $stat->total_exp,
                'rank_tier' => ucfirst($stat->rank_tier),
                'next_tier_exp' => 1000, // Dummy
                'is_active_today' => true,
            ]
        ]);
    }
}
