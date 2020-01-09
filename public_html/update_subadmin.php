<?php

// さぶ管理者の更新・削除

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Update_subadmin();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Update subadmin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">ID：<?= h($_GET['email']); ?></h1>
    </div>
    <div id="container">
        <h1 id="text">パスワードの更新</h1>
        <?php if(isset($_GET['update_password'])) { ?>
            <p id="center">パスワードを更新しました！！</p>
        <?php } ?>
        <form action="" method="post" id="update_password">
            <p>
                <input type="password" name="now_password" placeholder="now_password">
            </p>
            <p class="err"><?= h($app->getErrors('now_password')); ?></p>
            <p>
                <input type="password" name="new_password" placeholder="new_password">
            </p>
            <p class="err"><?= h($app->getErrors('new_password')); ?></p>

            <div class="btn" onclick="document.getElementById('update_password').submit();">Update</div>
            <input type="hidden" name="update" value="password">
            <input type="hidden" name="email" value="<?= h($_SESSION['me']->email); ?>">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
    </div>
    <div id="container">
        <h1 id="text">ニックネームの更新</h1>
        <form action="" method="post" id="update_nickname">
            <p>現在のニックネーム：<?= h($app->getValues()->nickname); ?></p>
            <p>
                <input type="text" name="new_nickname" placeholder="new_nickname">
            </p>
            <p class="err"><?= h($app->getErrors('new_nickname')); ?></p>
            <div class="btn" onclick="document.getElementById('update_nickname').submit();">Update</div>
            <input type="hidden" name="update" value="nickname">
            <input type="hidden" name="email" value="<?= h($_SESSION['me']->email); ?>">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
    </div>
    <div id="container">
        <h1 id="text">アカウント削除</h1>
        <form action="" method="post" id="delete">
            <p class="err"><?= h($app->getErrors('delete')); ?></p>
            <input type="submit" class="btn_edit" value="削除" onclick="return confirm('アカウントを削除します。本当によろしいですか？')">
            <!-- <div class="btn" onclick="document.getElementById('delete').submit();">Delete</div> -->
            <p class="err"><?= h($app->getErrors('delete')); ?></p>
            <input type="hidden" name="update" value="delete">
            <input type="hidden" name="email" value="<?= h($_SESSION['me']->email); ?>">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">

            <p class="fs12"><a href="/select_subadmin.php">管理者一覧</a></p>
        </form>
    </div>
    
</body>
</html>