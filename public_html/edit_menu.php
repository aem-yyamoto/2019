<?php

// タイトル・注意書き・ページャの編集の洗濯

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Edit_menu();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Edit menu</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">メインメニューの編集 </h1>
        <ul>
            <li>
                <p class="fs12"><a href="/edit_title.php">タイトルの編集</a></p>
            </li>
            <li>
                <p class="fs12"><a href="/edit_attention.php">注意書きの編集</a></p>
            </li>
            <li>
                <p class="fs12"><a href="/edit_pager.php">1ページに出力する記事の数を変更</a></p>
            </li>
        </ul>
        <p class="fs12"id="center"><a href="/management.php">管理画面</a></p>
    </div>
</body>
</html>
