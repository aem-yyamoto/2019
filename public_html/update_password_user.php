<?php

// ユーザーのpasswordの更新

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Update_password_user();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Update password user</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1>パスワードの更新</h1>
        <?php if(isset($_GET['update'])){?>
            <p id="center"> パスワードを更新しました！</p>
        <?php } ?>
        <form action="" method="post" id="signup">
            <p>
                <input type="password" name="now_password" placeholder="now_password">
            </p>
            <p class="err"><?= h($app->getErrors('now_password')); ?></p>
            <p>
                <input type="password" name="new_password" placeholder="new_password">
            </p>
            <p class="err"><?= h($app->getErrors('new_password')); ?></p>

            <div class="btn" onclick="document.getElementById('signup').submit();">Sign Up</div>
            <p class="fs12"><a href="/show_user_info.php">User Infoに戻る</a></p>
            <input type="hidden" name="email" value="<?= h($_SESSION['me']->email); ?>">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
    </div>
</body>
</html>