<?php

// ログイン

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Login();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Log In</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="container">
        <h1 id="text">ログイン</h1>
        <form action="" method="post" id="login">
            <p>
                <input type="text" name="email" placeholder="email"
                value="<?= isset($app->getValues()->email) ? h($app->getValues()->email) : ''; ?>">
            </p>
            <p>
                <input type="password" name="password" placeholder="password">
            </p>
            <p class="err"><?= h($app->getErrors('login')); ?></p>
            <div class="btn" onclick="document.getElementById('login').submit();">Log In</div>
            <p class="fs12"><a href="/signup.php">Sign Up</a></p>
            <p class="fs12"><a href="/login.php?mode=guest">Log in as Guest</a></p>
            <p class="fs12"><a href="/login_admin.php">Log in for Admin</a></p>
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
    </div>
</body>
</html>