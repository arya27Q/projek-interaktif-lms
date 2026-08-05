<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

var_dump(config('services.midtrans.is_production'));
var_dump(config('services.midtrans.server_key'));
