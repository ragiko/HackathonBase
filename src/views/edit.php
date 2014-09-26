<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
</head>
<body>
新規登録
<form action="" method="POST">
    <fieldset>

        <input type="hidden" name="id" value="<?php echo intval($user->id); ?>" readonly>

        <label>name</label>
        <input type="text" name="name" value="<?php echo h($user->name); ?>">

        <input type="submit" value="登録">
    </fieldset>
</form>

<hr>
<a href="/">一覧に戻る</a>
</body>
</html>
