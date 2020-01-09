<?php

// 管理画面

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Management();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">管理画面</h1>
        <form action="" method="post" id="management">
            <ul>
                <li>
                    <p class="fs12"><a href="/index.php">掲示板の閲覧</a></p>
                </li>
                <li>
                    <p class="fs12"><a href="/update_password_admin.php">自身のパスワードを変更</a></p>
                </li>
                <li>
                    <p class="fs12"><a href="/add_subadmin.php">サブ管理者の追加</a></p>
                </li>
                <li>
                    <p class="fs12"><a href="/select_subadmin.php">サブ管理者の更新・削除</a></p>
                </li>
                <li>
                    <p class="fs12"><a href="/admin_show_users.php">全ユーザー情報の参照</a></p>
                </li>
                <li>
                    <p class="fs12"><a href="/select_reflect.php">スレッド・投稿の反映方法</a></p>
                </li>
                <li>
                    <p class="fs12"><a href="/show_blacklist.php">ブラックリストの参照</a></p>
                </li>
                <li>
                    <p class="fs12"><a href="/select_editoradd_thread.php">スレッドの編集・追加</a></p>
                </li>
                <li>
                    <p class="fs12"><a href="/edit_category.php">カテゴリーの追加・削除</a></p>
                </li>
                <li>
                    <p class="fs12"><a href="/edit_menu.php">メインメニューの編集</a></p>
                </li>
            </ul>
        </form>
    </div>
</body>
</html>
