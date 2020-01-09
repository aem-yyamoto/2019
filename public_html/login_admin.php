<?php

// ログイン

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Login_admin();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Login for Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="container">
        <h1 id="text">admin</h1>
        <form action="" method="post" id="login_admin">
            <p>
                <input type="text" name="email" placeholder="email"
                value="<?= isset($app->getValues()->email) ? h($app->getValues()->email) : ''; ?>">
            </p>
            <p>
                <input type="password" name="password" placeholder="password">
            </p>
            <p class="err"><?= h($app->getErrors('login_admin')); ?></p>
            <div class="btn" onclick="document.getElementById('login_admin').submit();">Log In</div>
            <p class="fs12"><a href="/login.php">Log In for General</a></p>
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
    </div>
</body>
</html>