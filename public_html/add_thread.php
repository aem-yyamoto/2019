<?php

// スレッド追加

require_once(__DIR__ . '/../config/config.php');


$app = new MyApp\Controller\Add_thread();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Add thread</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">スレッド追加</h1>
        <form action="" method="post" id="add_thread">
            <p>
                <input type="text" name="title" placeholder="title" 
                value="<?= isset($app->getValues()->title) ? h($app->getValues()->title) : ''; ?>">
            </p>
            <p class="err"><?= h($app->getErrors('title')); ?></p>

            <p>
                <select name="category">
                <?php foreach($app->getValues()->categories as $category):  ?>
                    <option value="<?= h($category->category); ?>"><?= h($category->category); ?></option>
                <?php endforeach; ?>
                </select>
            </p>
            <p class="err"><?= h($app->getErrors('category')); ?></p>
            <div class="btn" onclick="document.getElementById('add_thread').submit();">Submit</div>
            <p class="fs12"><a href="/select_editoradd_thread.php">スレッド編集・追加</a></p>
            <input type="hidden" name="email" value="<?= h($app->me()->email); ?>">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
    </div>
</body>
</html>
