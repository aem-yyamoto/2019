<?php

// 記事を反映するか選択する

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Select_article_reflect();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Select article reflect</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>

    
    <div id="container">
        <h1 id="text"><?= h($app->getValues()->thread->title); ?></h1>
    <?php $reflectall = "/select_article_reflect.php?thread_id=".$_GET['thread_id']."&reflect=all"; ?>
    <p class="fs12" id="text"><a href="<?= h($reflectall); ?>">全ての記事を反映させる</a></p>
        <!-- ここに記事出力start -->
        <div>
            <form action="" method="post" id="checkbox">
            <?php
                foreach($app->getValues()->articles as $article):
                    if($article->thread_id === $_GET['thread_id']){?>
                        <div id="article">
                        <input type="checkbox" name="thread_ids[]" value="<?= h($article->article_id); ?>">
                            <?php if(!$article->flag_reflect){ ?>
                                <p id="attention">反映されていません</p>
                            <?php }?>
                            <label><?= h($article->article_id);?></label>
                            <label><?= h($article->nickname);?></label>
                            <label><?= h($article->created);?></label>
                            <p><?= h($article->text); ?></p>              
                            <!-- <input type="hidden" name="reflect" value="true"> -->
                            <input type="hidden" name="article_id" value="<?=h($article->article_id);?>">
                            <input type="hidden" name="thread_id" value="<?=h($article->thread_id);?>">
                            <input type="hidden" name="flag_reflect" value="<?=h($article->flag_reflect);?>">
                            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
                        </div>
                        
                    <?php } ?>
            <?php endforeach; ?>
            <p id="center"><input type="submit" value="反映させる"></p>
            <p class="fs12" id="text"><a href="/select_thread_reflect_post.php">スレッド一覧</a></p>
            </form>

        </div>
        <!-- ここに記事出力end -->
        
    </div>
</body>
</html>