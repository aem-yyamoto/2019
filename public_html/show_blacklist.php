<?php

// ブラックリストの参照と解除

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Show_blacklist();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Show blacklist</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">ブラックリストユーザー一覧 <span class="fs12">(<?= count($app->getValues()->blacklist); ?>)</span></h1>
        <ul>
            <?php foreach($app->getValues()->blacklist as $user): ?>
            <li>
                <p class="fs12"><?= h($user->user_id); ?>  <?= h($user->created); ?>
                <form action="" method="post">
                    <input type="submit" value="解除" onclick="return confirm('ブラックリストを解除すると対象のメールアドレスでアカウントを生成できるようになります。本当によろしいですか？')">
                    <p class="err"><?= h($app->getErrors('update')); ?></p>
                    <input type="hidden" name="email" value="<?= h($user->user_id); ?>">
                    <input type="hidden" name="unlock" value="true">
                    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
                </form>
                </p>
            </li>
            <?php endforeach; ?>
        </ul>
        <p class="fs12" id="text"><a href="/management.php">管理画面</a></p>
    </div>
</body>
</html>
