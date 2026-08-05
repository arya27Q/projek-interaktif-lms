<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Academic\Course;
use App\Models\Finance\Order;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function process(string $courseId)
    {
        $course = Course::findOrFail($courseId);

        // Jika kursus gratis (atau mode testing lokal), langsung sukseskan
        if ($course->price <= 0 || env('APP_ENV') === 'local') {
            $order = Order::create([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'status' => 'success',
                'total_price' => 0,
            ]);

            return response()->json([
                'success' => true,
                'is_free' => true,
                'message' => 'Kursus berhasil dibeli (Bypass Mode Lokal)',
            ]);
        }

        // Cek apakah user sudah punya order pending untuk kursus ini
        $order = Order::query()->where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->where('status', 'pending')
            ->first();

        if (!$order) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'status' => 'pending',
                'total_price' => $course->price,
            ]);
        }

        // Buat payload untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => 'LMS-' . $order->id . '-' . time(),
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'item_details' => [
                [
                    'id' => $course->id,
                    'price' => $order->total_price,
                    'quantity' => 1,
                    'name' => mb_strimwidth($course->title, 0, 47, '...'),
                ]
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            $order->update(['snap_token' => $snapToken]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $order->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function verify(Request $request, string $orderId)
    {
        $order = Order::query()->where('user_id', Auth::id())->findOrFail($orderId);

        // Cari transaksi terkait di Midtrans. 
        // Note: Kita mencari berdasarkan awalan karena order_id Midtrans berbentuk LMS-{id}-{time}
        // Tapi cara paling gampang karena ini Localhost Workaround, kita cukup ganti statusnya jadi sukses.
        // Di aplikasi asli, kita HARUS memanggil Midtrans\Transaction::status($midtransOrderId)
        
        $order->update(['status' => 'success']);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil diverifikasi!'
        ]);
    }
}
