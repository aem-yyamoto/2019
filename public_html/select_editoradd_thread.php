<?php

// スレッドを編集するか追加するかの選択画面

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Select_editOradd_thread();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Select edit or add thread</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">スレッド編集・追加 <span class="fs12">(<?= count($app->getValues()->users); ?>)</span></h1>
        <form action="" method="post" id="select_editoradd_thread">
            <ul>
                <li>
                    <p class="fs12"><a href="/select_thread.php">スレッドの編集</a></p>
                </li>
                <li>
                    <p class="fs12"><a href="/add_thread.php">スレッドの追加</a></p>
                </li>
            </ul>
            <p class="fs12"><a href="/management.php">管理画面</a></p>
        </form>
    </div>
</body>
</html>
