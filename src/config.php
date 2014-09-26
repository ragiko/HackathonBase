<?php

require __DIR__ . '/../vendor/autoload.php';

session_start();
session_cache_limiter(false);

/*
 * アプリ
 */
$app = new \Slim\Slim([
    'log.writer' => new \Slim\LogWriter(fopen('/tmp/app.log', 'a')),
    'log.level' => \Slim\Log::DEBUG,
    'log.enabled' => true,
    'templates.path' => __DIR__ . '/views',
]);

$app->container['db.host']      = 'localhost';
$app->container['db.database']  = 'test_treasure';
$app->container['db.user']      = 'treasure2014';
$app->container['db.password']  = 'treasure2014';

/*
 * DBの接続設定
 */
try {
    \ORM::configure([
        'connection_string' => sprintf('%s:host=%s;dbname=%s;port=%d', 
            'mysql', 
            $app->container['db.host'], 
            $app->container['db.database'], 
            3306),
        'username' => $app->container['db.user'],
        'password' => $app->container['db.password'] 
    ]);
} catch (Exception $e) {
    $app->halt(500, $e->getMessage());
}

return $app;
