<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$slug = 'tour-quy-nhon-ky-co-3n2d';
var_export([
  'slug_count' => App\Models\Tour::query()->where('slug', $slug)->count(),
  'same_name_count' => App\Models\Tour::query()->where('name', 'Quy Nhon – K? Co – Eo Gió')->count(),
]);
