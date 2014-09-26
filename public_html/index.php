<?php  

$app = include __DIR__ . '/../src/config.php';

require __DIR__ . '/../src/app/index.php';

// 実行
$app->run();

