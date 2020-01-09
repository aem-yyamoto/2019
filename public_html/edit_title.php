<?php

// 投稿の編集・削除

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Edit_title();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Edit title</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">タイトルの編集 <span class="fs12"></span></h1>
        
        <form action="" method="post" id="edit_title">
            <p>現在のタイトル：<?=  h($app->getValues()->main->title); ?></p>
            <p>
                <textarea id="message" name="new_title"></textarea>
            </p>
            <p class="err"><?= h($app->getErrors('title')); ?></p>
            <div class="btn" onclick="document.getElementById('edit_title').submit();">編集</div>
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>

        <p class="fs12" id="center"><a href="/edit_menu.php">メインメニューの編集に戻る</a></p>
    </div>　
        
</body>
</html>
