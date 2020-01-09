<?php

// カテゴリーの編集

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Edit_category();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Edit Category</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">カテゴリーの編集 </h1>
        <ul>
            <li>
                <p class="fs12"><a href="/add_category.php">カテゴリーの追加</a></p>
            </li>
            <li>
                <p class="fs12"><a href="/delete_category.php">カテゴリーの削除</a></p>
            </li>
        </ul>
        <p class="fs12"id="center"><a href="/management.php">管理画面</a></p>
    </div>
</body>
</html>
