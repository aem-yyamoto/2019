<?php

// 編集したいスレッドも洗濯

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Select_thread();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Select thread</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">スレッド一覧 <span class="fs12">(<?= count($app->getValues()->users); ?>)</span></h1>
        <ul>
            <?php foreach($app->getValues()->threads as $thread): ?>
            <li>
                <p class="fs12"><a href="/edit_thread.php?select_thread=<?= h($thread->title); ?>&select_thread_category=<?= h($thread->category); ?>&thread_id=<?= h($thread->thread_id); ?>"><?= h($thread->title); ?> </a></p>
            </li>
            <?php endforeach; ?>
        </ul>
        
        <p class="fs12" id="center"><a href="/select_editoradd_thread.php">スレッド編集・追加</a></p>
        <!-- <?php var_dump($app->me()->nickname); ?> -->
    </div>
</body>
</html>
