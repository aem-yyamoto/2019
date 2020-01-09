<?php

// 管理者によるユーザーの洗濯

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Admin_Show_users();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Admin show users</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">ユーザー一覧 <span class="fs12">(<?= count($app->getValues()->users); ?>)</span></h1>
        <ul>
            <?php foreach($app->getValues()->users as $user): ?>
            <li>
                <p class="fs12"><a href="/admin_show_user.php?email=<?= h($user->email); ?>"><?= h($user->nickname); ?></a><?php if($user->flag_admin)echo "  admin"; ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
        <p class="fs12" id="text"><a href="/management.php">管理画面</a></p>
    </div>
</body>
</html>
