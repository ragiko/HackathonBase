<?php

/**
 * Slim と Idiorm をつかたサンプルコード
 *
 * Copyright (c) 2013 maki koiwa
 * This software is released under the MIT License.
 * http://opensource.org/licenses/mit-license.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = include __DIR__ . '/config.php';


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


/*
 * トップページ
 * 一覧表示
 */
$app->get('/', function() use ($app) {

    $users = array();
    try {
        $users = \ORM::for_table('users')->find_many();
        $app->view()->setData('users', $users);


        $tweets = findTweetByUserName('taguchi');
        print_r($tweets);


        $app->view()->display('index.php');
    } catch (Exception $e) {
        $app->halt(500, $e->getMessage());
    }
});

/*
 * ユーザ名からモデルを取得
 */
function findByName($name) {
    $user = ORM::for_table('users')
        ->where_equal('name', $name)
        ->find_one();

    return $user;
}

/*
 * ユーザのtweetを取得
 */
function findTweetByUserName($user_name) {
    $tweet_objs = ORM::for_table('tweet')
        ->select('tweet.*')
        ->join('users', array(
            'users.id', '=', 'tweet.user_id'
        ))
        ->where_equal('users.name', $user_name)
        ->find_many();

    $tweets = array_map(function ($x) {
        return $x->tweet;
    }, $tweet_objs);

    return $tweets;
}

/*
 * 詳細
 */
$app->get('/users/:id', function($id) use ($app) {
    $user = \ORM::for_table('users')->find_one($id);
    if (false === $user) {
        $app->halt(404);
    }
    $app->view()->setData('user', $user);
    $app->view()->display('detail.php');
});

/*
 * 新規登録フォーム
 */
$app->get('/create', function() use ($app) {
    $app->view()->display('create.php');
});



/*
 * 新規登録処理
 */
$app->post('/create', function() use ($app) {
    \ORM::get_db()->beginTransaction();
    try {
        $user = ORM::for_table('users')->create();
        $user->name = $app->request->post('name');
        $user->updated_at = date("Y-m-d H:i:s");
        $user->created_at = $user->updated_at;
        $user->save();
        \ORM::get_db()->commit();

        $app->flash('info', ('新規登録しました。'));

        // 一覧に戻る
        $app->redirect($app->request->getRootUri() . '/');

    } catch (PDOException $e) {
        \ORM::get_db()->rollBack();
        $app->view()->setData('error', $e->getMessage());
        $app->view()->display('create.php');
    }
});



/*
 * 編集フォーム
 */
$app->get('/:id/edit', function($id) use ($app) {
    $user = \ORM::for_table('users')->find_one($id);
    if (false === $user) {
        if (false === $user) {
            $app->halt(404);
        }
    }

    $app->view()->setData('user', $user);
    $app->view()->display('edit.php');
});



/*
 * フォームから POST時
 */
$app->post('/:id/edit', function($id) use ($app) {
    $user = \ORM::for_table('users')->find_one($id);
    if (false === $user) {
        $app->halt(404);
    }

    \ORM::get_db()->beginTransaction();
    try {
        $user->name = $app->request->post('name');
        $user->save();
        \ORM::get_db()->commit();
        $app->flash('info', ('変更しました。'));

        // 一覧に戻る
        $app->redirect($app->request->getRootUri() . '/');

    } catch (PDOException $e) {
        \ORM::get_db()->rollBack();
        $app->view()->setData('user', $user);
        $app->view()->display('edit.php');
    }
});



/*
 * 削除
 */
$app->get('/:id/delete', function($id) use ($app) {

    \ORM::get_db()->beginTransaction();
    try {
        $user = \ORM::for_table('users')->find_one($id);
        $user->delete();
        \ORM::get_db()->commit();
        $app->flash('info', ('削除しました。'));

    } catch (PDOException $e) {
        \ORM::get_db()->rollBack();
        $app->flash('error', sprintf('削除できませんでした。 %s', $e->getMessage()));
    }

    // 一覧に戻る
    $app->redirect($app->request->getRootUri() . '/');

});



/*
 * phpinfo
 */
$app->get('/info', function() {
    phpinfo();
});



// 実行
$app->run();


/**
 * htmlspecialchars() の便利なラッパー
 * テンプレート側で使う用途
 *
 * @param $string
 * @return string
 */
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
