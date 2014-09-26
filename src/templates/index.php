<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>一覧</title>
</head>
<body>
<h1>INDEX</h1>
<?php

if (isset($flash['info'])) {
    printf('<p>%s</p>', h($flash['info']));
}

if (isset($flash['error'])) {
    printf('<p>%s</p>', h($flash['error']));
}

foreach ($users as $user) {
    printf('%s <small><a href="./users/%d">詳細</a></small>', h($user->name), $user->id);
    echo "<br>\n";
}
?>

<hr>
<a href="/create">新規登録</a>
</body>
</html>
