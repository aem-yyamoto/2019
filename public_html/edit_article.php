<?php

// 投稿の編集・削除

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Edit_article();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Edit article</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">投稿の編集・削除 <span class="fs12"></span></h1>
        <form action="" method="post" id="edit_text">
            <p>現在のテキスト：<?=  h($app->getValues()->now_text); ?></p>
            <p>
                <textarea id="message" name="new_text"></textarea>
            </p>
            <p class="err"><?= h($app->getErrors('text')); ?></p>
            <input type="submit" class="btn_edit" value="編集" onclick="return confirm('投稿内容を編集します。本当によろしいですか？')">
            <input type="hidden" name="now_text" value="<?= h($app->getValues()->now_text); ?>">
            <input type="hidden" name="article_id" value="<?= h($app->getValues()->article_id); ?>">
            <input type="hidden" name="thread_id" value="<?= h($app->getValues()->thread_id); ?>">
            <input type="hidden" name="select_thread" value="<?= h($app->getValues()->select_thread); ?>">
            <input type="hidden" name="select_thread_category" value="<?= h($app->getValues()->select_thread_category); ?>">
            <input type="hidden" name="page" value="<?= h($app->getValues()->page); ?>">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>

        <?php $path="/thread.php?select_thread=".$_POST['select_thread']."&select_thread_category=".$_POST['select_thread_category']."&thread_id=".$_POST['thread_id']."&page=".$_POST['page']; ?>
        <!-- <form action="<?= h($path); ?>" method="post"> -->
        <form action="" method="post">
            <input type="submit" value="削除" onclick="return confirm('投稿内容を削除します。本当によろしいですか？')">
            <input type="hidden" name="update" value="delete">
            <input type="hidden" name="article_id" value="<?= h($app->getValues()->article_id); ?>">
            <input type="hidden" name="thread_id" value="<?= h($app->getValues()->thread_id); ?>">
            <input type="hidden" name="select_thread" value="<?= h($app->getValues()->select_thread); ?>">
            <input type="hidden" name="select_thread_category" value="<?= h($app->getValues()->select_thread_category); ?>">
            <input type="hidden" name="page" value="<?= h($app->getValues()->page); ?>">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
            <br>
            <!-- ここでスレッドに戻りたいから前のページのGETの情報が必要！！ -->
            <p class="fs12"><a href="/thread.php?select_thread=<?= h($_POST['select_thread']); ?>&select_thread_category=<?= h($_POST['select_thread_category']); ?>&thread_id=<?= h($_POST['thread_id']); ?>&page=<?= h($_POST['page']); ?>">スレッドに戻る</a></p>
        </form>
    </div>　
        
</body>
</html>
