<?php

// 管理者によるユーザーの情報を表示

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Admin_Show_user();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Admin show user</title>
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
            <p><?php 
                if($app->getValues()->user_info->flag_reflect){echo "即時反映";}
                else{echo "管理者による反映";} 
            ?></p>
        </ul>
    </div>
    <div id="container">
        <?php if(!$app->getValues()->user_info->flag_admin) {?>
        <h1 id="text">ブラックリストへの追加</h1>
        <form action="blacklist.php" method="post">
            <input type="submit" value="ブラックリストに追加" onclick="return confirm('ブラックリストに追加すると強制退会され、データが削除されます。本当によろしいですか？')">
            <p class="err"><?= h($app->getErrors('email')); ?></p>
            <input type="hidden" name="form" value="blacklist">
            <input type="hidden" name="user_id" value="<?= h($app->getValues()->user_info->email); ?>">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
        <?php } ?>
        <p class="fs12" id="text"><a href="/admin_show_users.php">ユーザー一覧</a></p>
    </div>
    
</body>
</html>
