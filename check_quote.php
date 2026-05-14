<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$quote = App\Models\Quote::with('items')->find(4);
$items = $quote->items->toArray();

echo "items count: " . count($items) . "\n";
echo "toArray output:\n";
print_r($items);

echo "\n@json output:\n";
echo \Illuminate\Support\Js::from($items)->toHtml();
echo "\n";

echo "\nold('items') would be: " . (session()->has('_old_input') ? 'HAS OLD INPUT' : 'null (no flash)') . "\n";
