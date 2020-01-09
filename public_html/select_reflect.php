<?php

// 何の反映についてかを選択する画面

require_once(__DIR__ . '/../config/config.php');


$app = new MyApp\Controller\Select_reflect();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Select reflect</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">スレッド・投稿の反映方法</h1>
        <form action="" method="post" id="select_reflect">
            <ul>
                <li>
                    <p class="fs12"><a href="/select_user_reflect.php">ユーザー投稿の反映方法</a></p>
                </li>
                <li>
                    <p class="fs12"><a href="/select_thread_reflect.php">スレッド投稿の反映方法</a></p>
                </li>
                <li>
                    <p class="fs12"><a href="/select_thread_reflect_post.php">投稿された記事の反映</a></p>
                </li>
            </ul>
            <p class="fs12"><a href="/management.php">管理画面</a></p>
        </form>
    </div>
</body>
</html>
