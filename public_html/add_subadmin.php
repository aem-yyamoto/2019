<?php

// サブ管理者の追加

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Add_subadmin();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Add_subadmin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">サブ管理者登録</h1>
        <?php if(isset($_GET['update'])){ ?>
            <p id="center">登録完了！</p>
        <?php } ?>
        <form action="" method="post" id="signup">
            <p>
                <input type="text" name="email" placeholder="email" 
                value="<?= isset($app->getValues()->email) ? h($app->getValues()->email) : ''; ?>">
            </p>
            <p class="err"><?= h($app->getErrors('email')); ?></p>
            <p>
                <input type="text" name="nickname" placeholder="nickname" 
                value="<?= isset($app->getValues()->nickname) ? h($app->getValues()->nickname) : ''; ?>">
            </p>
            <p class="err"><?= h($app->getErrors('nickname')); ?></p>
            <p>
                <input type="password" name="password" placeholder="password">
            </p>
            <p class="err"><?= h($app->getErrors('password')); ?></p>
            <div class="btn" onclick="document.getElementById('signup').submit();">Sign Up</div>
            <p class="fs12"><a href="/management.php">管理画面</a></p>
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
    </div>
</body>
</html>