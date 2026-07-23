<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(new Illuminate\Http\Request);

use Illuminate\Support\Facades\Mail;

echo 'MAIL_MAILER: ' . config('mail.default') . PHP_EOL;
echo 'MAIL_HOST: ' . config('mail.mailers.smtp.host') . PHP_EOL;
echo 'MAIL_FROM: ' . config('mail.from.address') . PHP_EOL;

try {
    Mail::raw('Test from product_inventory', function ($m) {
        $m->to('risingbappy1@gmail.com')->subject('Product Inventory Mail Test');
    });
    echo 'SENT OK' . PHP_EOL;
} catch (\Throwable $e) {
    echo 'FAILED: ' . $e->getMessage() . PHP_EOL;
}
