<?php  

$app = include __DIR__ . '/../src/config.php';

// コントローラを追加
require __DIR__ . '/../src/app/user.php';
require __DIR__ . '/../src/app/api.php';

// 実行
$app->run();

