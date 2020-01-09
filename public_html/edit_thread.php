<?php

// スレッド編集

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Edit_thread();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Edit thread</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>

    <div id="container">
        <h1 id="text">スレッド編集</h1>
        <form action="" method="post" id="edit_title">
            <p>現在のタイトル：<?=  h($_GET['select_thread']); ?></p>
            <p>
                <input type="text" name="title" placeholder="title" 
                value="<?= isset($app->getValues()->title) ? h($app->getValues()->title) : ''; ?>">
            </p>
            <p class="err"><?= h($app->getErrors('title')); ?></p>
            <div class="btn" onclick="document.getElementById('edit_title').submit();">タイトル編集</div>
            <input type="hidden" name="edit" value="title">
            <input type="hidden" name="thread_id" value="<?= h($_GET['thread_id']); ?>">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
        <br>
        <form action="" method="post" id="edit_category">
            <p>現在のカテゴリー：<?=  h($_GET['select_thread_category']); ?></p>
            <p>
                <select name="category_id">
                    <?php foreach($app->getValues()->categories as $category):  ?>
                        <option value="<?= h($category->category_id); ?>"<?php if($category->category == $_GET['select_thread_category']){ ?>selected<?php }?>><?= h($category->category); ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p class="err"><?= h($app->getErrors('category')); ?></p>
            <div class="btn" onclick="document.getElementById('edit_category').submit();">カテゴリー編集</div>
            <input type="hidden" name="edit" value="category">
            <input type="hidden" name="thread_id" value="<?= h($_GET['thread_id']); ?>">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
        <form action="" method="post" id="delete_thread">
            <input type="submit" class="btn_edit" value="スレッド削除" onclick="return confirm('スレッドを削除します。本当によろしいですか？')">
            <!-- <div class="btn" onclick="document.getElementById('delete_thread').submit();">スレッド削除</div> -->
            <input type="hidden" name="edit" value="delete_thread">
            <input type="hidden" name="thread_id" value="<?= h($_GET['thread_id']); ?>">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
        <p class="fs12" id="text"><a href="/select_thread.php">スレッド一覧に戻る</a></p>
        
    </div>
</body>
</html>
