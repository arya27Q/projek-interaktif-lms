<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Academic\Course;
use App\Models\Finance\Order;
use Midtrans\Config;
use Midtrans\Snap;

Config::$serverKey = config('services.midtrans.server_key');
Config::$isProduction = config('services.midtrans.is_production');
Config::$isSanitized = config('services.midtrans.is_sanitized');
Config::$is3ds = config('services.midtrans.is_3ds');

echo "Server Key: " . Config::$serverKey . "\n";

$params = [
    'transaction_details' => [
        'order_id' => 'LMS-TEST-' . time(),
        'gross_amount' => 10000,
    ],
    'customer_details' => [
        'first_name' => 'Test',
        'email' => 'test@test.com',
    ],
    'item_details' => [
        [
            'id' => 1,
            'price' => 10000,
            'quantity' => 1,
            'name' => 'Test Course',
        ]
    ]
];

try {
    $snapToken = Snap::getSnapToken($params);
    echo "Snap Token: " . $snapToken . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
