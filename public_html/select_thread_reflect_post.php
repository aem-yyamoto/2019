<?php

// 記事の反映

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Select_thread_reflect_post();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Select thread reflect post</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">スレッド一覧(反映されていない投稿数)</h1>
            <ul>
                <?php 
                    $i = 0;
                    foreach($app->getValues()->threads as $thread):
                        $name = "form".$i;
                        $path="javascript:form".$i.".submit()";
                        $thread_id = $thread->thread_id;
                        $next_url = "/select_article_reflect.php?thread_id=".$thread->thread_id;
                ?>
                <form action=<?=h($next_url);?> method="post" id="select_thread_reflect" name="<?= h($name); ?>">
                    <li>
                        <p class="fs12" id="left"><a href="<?= h($path); ?>"><?= h($thread->title); ?></a> <?= h($app->getValues()->$thread_id); ?></p>
                        <input type="hidden" name="thread_title" value="<?= h($thread->title); ?>">
                        <!-- <input type="hidden" name="thread_id" value="<?= h($thread->thread_id); ?>"> -->
                        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
                    </li>
                    <?php $i += 1;?>
                </form>
                <?php endforeach; ?>
            </ul>
        
        <p class="err"><?= h($app->getErrors('update')); ?></p>
        <p class="fs12" id="text"><a href="/select_reflect.php">スレッド・投稿の反映方法</a></p>
    </div>
</body>
</html>
