<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Courses: " . \App\Models\Academic\Course::count() . "\n";
echo "Published: " . \App\Models\Academic\Course::where('status', 'published')->count() . "\n";
