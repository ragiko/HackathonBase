<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>詳細</title>
</head>
<body>
<h1>詳細</h1>

<a href="<?php printf('/%s/edit', intval($user->id)); ?>">編集</a>
|
<a href="<?php printf('/%s/delete', intval($user->id)); ?>">削除</a>

<table border="1" >
    <tr>
        <th>ID</th>
        <th>name</th>
    </tr>
    <tr>
        <td><?php echo intval($user->id); ?></td>
        <td><?php echo h($user->name); ?></td>
    </tr>
</table>

<hr>
<a href="/">一覧に戻る</a>

</body>
</html>

