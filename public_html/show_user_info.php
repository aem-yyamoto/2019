<?php

// ユーザーの情報を表示

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Show_user_info();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Show user info</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">ユーザー情報(<?= h($app->getValues()->user_info->nickname); ?>)</h1>
        <ul>
            <li>email</li>
            <p><?= h($app->getValues()->user_info->email); ?></p>
            <li>created</li>
            <p><?= h($app->getValues()->user_info->created); ?></p>
            <li>modified</li>
            <p><?= h($app->getValues()->user_info->modified); ?></p>
            <li>num_post</li>
            <p><?= h($app->getValues()->user_info->num_post); ?></p>
            <li>total_good</li>
            <p><?= h($app->getValues()->user_info->total_good); ?></p>
            <li>nickname</li>
            <p><?= h($app->getValues()->user_info->nickname); ?></p>
            <li>flag_admin</li>
            <p><?= h($app->getValues()->user_info->flag_admin); ?></p>
            <li>flag_reflect</li>
            <p><?= h($app->getValues()->user_info->flag_reflect); ?></p>
        </ul>

        <?php if(!$_SESSION['me']->flag_admin){ ?>
        <p class="fs12" id="text"><a href="/update_password_user.php">パスワードの変更</a></p>
        <!-- 退会 -->
        <form action="unsubscribe_user.php" method="post">
            <input type="submit" value="退会" onclick="return confirm('退会するとデータが削除されます。本当によろしいですか？')">
            <p class="err"><?= h($app->getErrors('email')); ?></p>
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
        <!-- 退会end -->
        <?php } ?>
        
        <p class="fs12" id="text"><a href="/index.php">掲示板に戻る</a></p>
    </div>
</body>
</html>
