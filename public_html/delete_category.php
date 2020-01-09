<?php

// カテゴリーの削除

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Delete_category();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Delete category</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <div id="container">
        <h1 id="text">カテゴリーの削除 <span class="fs12"></span></h1>
        
        <form action="" method="post" id="delete_category">
            <p>
                <select name="category_id">
                <?php foreach($app->getValues()->categories as $category):  ?>
                    <option value="<?= h($category->category_id); ?>"><?= h($category->category); ?></option>
                <?php endforeach; ?>
                </select>
            </p>
            <p class="err"><?= h($app->getErrors('category')); ?></p>
            <input type="submit" class="btn_edit" value="削除" onclick="return confirm('カテゴリーを削除します。本当によろしいですか？')">
            <!-- <div class="btn" onclick="document.getElementById('delete_category').submit();">削除</div> -->
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>

        <p class="fs12" id="center"><a href="/edit_category.php">メインメニューの編集に戻る</a></p>
    </div>
        
</body>
</html>
