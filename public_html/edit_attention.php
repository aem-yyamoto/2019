<?php

// 注意書きの編集

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Edit_attention();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Edit attention</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">注意書きの編集 <span class="fs12"></span></h1>
        
        <form action="" method="post" id="edit_attention">
            <p>現在の注意書き：<?=  h($app->getValues()->main->attention); ?></p>
            <p>
                <textarea id="message" name="new_attention"></textarea>
            </p>
            <p class="err"><?= h($app->getErrors('attention')); ?></p>
            <div class="btn" onclick="document.getElementById('edit_attention').submit();">編集</div>
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>

        <p class="fs12" id="center"><a href="/edit_menu.php">メインメニューの編集に戻る</a></p>
    </div>　
        
</body>
</html>
