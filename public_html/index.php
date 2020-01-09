<?php

// 掲示板のトップ

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Index();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
    <!-- user's info -->
    <?php if($_SESSION['me']->email !== "guest@gmail.com"){ ?>
        <form action="show_user_info.php" method="post" id="right">
            <input type="submit" value="User Info">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
    <?php } ?>
    
    <div id="container">
        <h1 id="text"><?= h($app->getValues()->main->title); ?></h1>
        <?php if($app->getValues()->main->attention != ""){ ?>
            <p id="attention" class="fs12">**注意書き**</p>
            <p class="fs12">　<?= h($app->getValues()->main->attention); ?></p>
        <?php } ?>
        <!-- カテゴリーによるスレッドの検索 -->
        <form action="" method="post" id="serch_category">
            <p>
                <select name="category_id">
                <?php foreach($app->getValues()->categories as $category):  ?>
                    <option value="<?= h($category->category_id); ?>" <?php if(isset($app->getValues()->serch_category) && $app->getValues()->serch_category==$category->category){ ?>selected<?php }?>><?= h($category->category); ?></option>
                <?php endforeach; ?>
                </select>
                <input type="submit" value="検索">
                <p class="fs12"><a href="/index.php">全てのスレッドを表示する</p>
            </p>
            <p class="err"><?= h($app->getErrors('category')); ?></p>
            <input type="hidden" name="form" value="serch_threads">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
        <!-- カテゴリーによるスレッドの検索end -->
        <?php if(isset($app->getValues()->serch_threads)){ ?>
            <ul>
            <?php
                foreach($app->getValues()->serch_threads as $thread): 
                    if($thread->flag_reflect){
            ?>
            <li>
                <p class="fs12"><a href="/thread.php?select_thread=<?= h($thread->title); ?>&select_thread_category=<?= h($thread->category); ?>&thread_id=<?= h($thread->thread_id); ?>&page=1"><?= h($thread->title); ?> </a></p>
            </li>
            <?php
                    } 
                endforeach;
            ?>
            </ul>
        <?php }else{ ?>
            <ul>
                <?php
                    foreach($app->getValues()->threads as $thread): 
                        if($thread->flag_reflect){
                ?>
                <li>
                    <p class="fs12"><a href="/thread.php?select_thread=<?= h($thread->title); ?>&select_thread_category=<?= h($thread->category); ?>&thread_id=<?= h($thread->thread_id); ?>&page=1"><?= h($thread->title); ?> </a></p>
                </li>
                <?php
                        } 
                    endforeach;
                ?>
            </ul>
        <?php } ?>
        <?php if($app->me()->flag_admin){?>
            <p class="fs12" id="text"><a href="/management.php">管理画面</a></p>
        <?php } ?>
       
    </div>
</body>
</html>
