<?php

// サブ管理者の表示

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Select_subadmin();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Select subadmin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <?php if($app->me()->email === "admin@gmail.com"){ ?>
        <h1 id="text">管理者一覧 <span class="fs12">(<?= count($app->getValues()->users)-1; ?>)</span></h1>
        <ul>
            <?php foreach($app->getValues()->users as $user): ?>
                <?php if($user->email !== "admin@gmail.com"){ ?>
                    <li>
                        <p class="fs12"><a href="/update_subadmin.php?email=<?= h($user->email); ?>"><?= h($user->nickname); ?></a><?php if($user->flag_admin)echo "  admin"; ?></p>
                    </li>
                <?php } ?>
            <?php endforeach; ?>
        </ul>
        <?php }else{ ?>
            <p id="attention_center">サブ管理者は操作できません</p>
        <?php }?>
        <p class="fs12" id="text"><a href="/management.php">管理画面</a></p>
    </div>
</body>
</html>
