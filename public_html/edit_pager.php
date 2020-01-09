<?php

// pagerの設定　１ページに出力する記事の数

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Edit_pager();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Edit pager</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">ページャの編集 <span class="fs12"></span></h1>
        
        <form action="" method="post" id="edit_pager">
            <p>現在の１ページに出力する記事の数：<?=  h($app->getValues()->pager->show_num); ?></p>
            <p>
                <textarea id="message" name="new_pager"></textarea>
            </p>
            <p class="err"><?= h($app->getErrors('pager')); ?></p>
            <div class="btn" onclick="document.getElementById('edit_pager').submit();">編集</div>
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>

        <p class="fs12" id="center"><a href="/edit_menu.php">メインメニューの編集に戻る</a></p>
    </div>　
        
</body>
</html>
