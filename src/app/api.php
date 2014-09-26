<?php
/**
 * サンプル API コントローラー
 */

/**
 * JSON のレスポンス
 */
$app->container['response.json'] = $app->container->protect(function (\Slim\Http\Response $response) {
    return function ($data, $status = 200) use ($response) {
        $response->setStatus($status);
        $response->headers->set('Content-Type', 'application/json');
        // Encode <, >, ', &, and " for RFC4627-compliant JSON, which may also be embedded into HTML.
        $jsonBody = json_encode(['data' => $data], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
        $response->setBody($jsonBody);
    };
});

// json response を返すために用意したメソッドの準備
$jsonResponse = $app->container['response.json']($app->response);

/**
 * ユーザー一覧
 */
$app->get('/api/user/:id', function ($id) use ($jsonResponse) {
    $user = \ORM::for_table('users')
        ->where('id', $id)
        ->find_array();

    $jsonResponse($user);
});

