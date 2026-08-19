<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = config('products');

foreach ($products as $slug => $details) {
    App\Models\Product::updateOrCreate(
        ['slug' => $slug],
        [
            'name' => $details['name'],
            'short_description' => $details['description'],
            'price' => $details['price'],
            'images' => [$details['image']],
            'download_file_path' => $details['pdf_path'],
            'status' => 'active'
        ]
    );
}

echo "Products migrated to database successfully.\n";
