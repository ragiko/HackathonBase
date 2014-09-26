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
        <?php if (isset($error)) { echo h($error) . "<br>\n"; } ?>

        <label>name</label>
        <input type="text" name="name" value="">

        <input type="submit" value="登録">
    </fieldset>
</form>

<hr>
<a href="/">一覧に戻る</a>
</body>
</html>