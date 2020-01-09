<?php

// いいねの参照

require_once(__DIR__ . '/../config/config.php');

// var_dump($_SESSION['me']);

$app = new MyApp\Controller\Good_reference();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Good reference</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    
    <div id="container">
        <h1 id="text"><?= h($app->getValues()->select_thread); ?></h1>
        <ul>
            <?php
                foreach($app->getValues()->goods as $good): 
            ?>
            <li>
                <?php 
                    if($good->flag_exist){echo h($app->getNickname($good->from_user_id));}
                    else{echo h("Unknown");}
                 ?>
            </li>
            <?php
                endforeach;
            ?>
        </ul>

        <p class="fs12" id="center"><a href="/thread.php?select_thread=<?= h($app->getValues()->select_thread); ?>&select_thread_category=<?= h($app->getValues()->select_thread_category); ?>&thread_id=<?= h($app->getValues()->thread_id); ?>&page=<?= h($app->getValues()->page); ?>">スレッド：<?= h($app->getValues()->select_thread); ?>に戻る</a></p>
    </div>
</body>
</html>
