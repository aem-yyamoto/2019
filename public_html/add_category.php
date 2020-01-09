<?php

// カテゴリーの追加

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Add_category();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Add Category</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">カテゴリーの追加</h1>
        <?php foreach($app->getValues()->categories as $category):  ?>
            <p class="fs12" id="center"><?= h($category->category); ?></p>
        <?php endforeach; ?>
        <form action="" method="post" id="category">
            <p>
                <input type="text" name="category" placeholder="category" 
                value="<?= isset($app->getValues()->email) ? h($app->getValues()->email) : ''; ?>">
            </p>
            <p class="err"><?= h($app->getErrors('category')); ?></p>
            <div class="btn" onclick="document.getElementById('category').submit();">追加</div>
            <p class="fs12"><a href="/edit_category.php">カテゴリーの編集に戻る</a></p>
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
    </div>
</body>
</html>