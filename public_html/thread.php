<?php

// 掲示板のスレッドの中(記事一覧)

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Thread();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title><?= h($_GET['select_thread']); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- logoutのフォーム -->
    <form action="logout.php" method="post" id="logout"> <!-- actionが跳び先のファイル -->
        <?= h($app->me()->email); ?><input type="submit" value="Log Out" onclick="return confirm('ログアウトします。本当によろしいですか？')">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form> 
    
    <div id="container">
    <h1 id="text"><?= h($_GET['select_thread']); ?></h1>
        <!-- ここに記事出力start -->
        <div>
            <?php foreach($app->getValues()->articles as $article):
                    if($article->flag_reflect){// articlesは関連記事のみ
                        // if(!$app->me()->flag_admin && !$article->flag_exist) continue;
            ?>
                        <div id="article">
                            <!-- 引用の記事 -->
                            <?php if($article->quote_article_id !== null){ ?>
                                <details>
                                    <?php $i = 0; $count = count($app->getValues()->allarticle_thread);?>
                                    <summary>>><?= h($article->quote_article_id);?></summary>
                                    <div id="container_sub">
                                    <?php foreach($app->getValues()->allarticle_thread as $a):
                                            if($a->article_id == $article->quote_article_id){
                                     ?>
                                        <p>nickname:<?= h($a->nickname); ?></p>
                                        <p><?= h($a->text); ?></p>
                                    <?php   break;}
                                            $i += 1;
                                        endforeach;
                                        if($i >= $count){
                                    ?>
                                            <p>NotFound</p>
                                    <?php } ?>
                                    </div>
                                </details>
                            <?php } ?>
                            <!-- 引用の記事end -->
                            <label><?= h($article->article_id);?></label>
                            <?php if($article->flag_exist){?>
                            <label><?= h($article->nickname);?></label>
                            <?php }else{echo "Unknown";} ?>
                            <label><?= h($article->created);?></label>
                            <p><?= h($article->text); ?></p>
                            <!-- 編集ボタン -->
                            <?php if(($article->created_user_id === $_SESSION['me']->email && $article->flag_exist) || $_SESSION['me']->flag_admin){?>
                                <form action="edit_article.php" method="post" id="right">
                                    <input type="submit" value="編集">
                                    <input type="hidden" name="from" value="thread">
                                    <input type="hidden" name="now_text" value="<?= h($article->text); ?>">
                                    <input type="hidden" name="article_id" value="<?= h($article->article_id); ?>">
                                    <input type="hidden" name="thread_id" value="<?= h($_GET['thread_id']); ?>">
                                    <input type="hidden" name="select_thread" value="<?= h($_GET['select_thread']); ?>">
                                    <input type="hidden" name="select_thread_category" value="<?= h($_GET['select_thread_category']); ?>">
                                    <input type="hidden" name="page" value="<?= h($_GET['page']); ?>">
                                    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
                                </form>
                            <?php } ?> 
                            <!-- 編集ボタンend -->

                            <!-- 引用ボタン -->
                            <?php if(($article->created_user_id !== $_SESSION['me']->email && $article->flag_exist && $app->me()->email != "guest@gmail.com") || $_SESSION['me']->flag_admin){?>
                                <form action="" method="post" id="right">
                                    <input type="submit" value="引用">
                                    <input type="hidden" name="from" value="quote">
                                    <input type="hidden" name="now_text" value="<?= h($article->text); ?>">
                                    <input type="hidden" name="article_id" value="<?= h($article->article_id); ?>">
                                    <input type="hidden" name="thread_id" value="<?= h($_GET['thread_id']); ?>">
                                    <input type="hidden" name="select_thread" value="<?= h($_GET['select_thread']); ?>">
                                    <input type="hidden" name="select_thread_category" value="<?= h($_GET['select_thread_category']); ?>">
                                    <input type="hidden" name="page" value="<?= h($_GET['page']); ?>">
                                    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
                                </form>
                            <?php } ?> 
                            <!-- 引用ボタンend -->

                            <!-- いいねボタン -->
                            <?php
                                $i = 0; // いいねカウント(flag_existのカウントなし)
                                $j = 0; // いいねカウント(flag_existのカウントあり)
                                foreach($app->getValues()->goods_thread as $good):
                                    if($article->article_id === $good->article_id){
                                        $j += 1;
                                        // 自分がいいねしていて、いいねしたアカウントが存在していルカ
                                        if($good->from_user_id === $app->me()->email && $good->flag_exist){
                                            $i = 1;
                                        }
                                    }
                                endforeach;

                                // 自分が投稿した記事かの判定
                                if($article->created_user_id !== $_SESSION['me']->email){//自分の記事でないとき
                                    if($app->me()->email === "guest@gmail.com"){?>
                                        <p id="right"><label>いいね！<?php echo $j;?></label></p>
                            <?php   }else{ 
                                        if($app->me()->flag_admin){// 全て参照できるいいねボタン?>
                                            <form action="good_reference.php" method="post" id="right">
                                                <input type="submit" value="いいね！<?php if($j != 0){echo $j;} ?>" id="good">
                                                <input type="hidden" name="article_id" value="<?= h($article->article_id); ?>">
                                                <input type="hidden" name="thread_id" value="<?= h($_GET['thread_id']); ?>">
                                                <input type="hidden" name="select_thread" value="<?= h($_GET['select_thread']); ?>">
                                                <input type="hidden" name="select_thread_category" value="<?= h($_GET['select_thread_category']); ?>">
                                                <input type="hidden" name="page" value="<?= h($_GET['page']); ?>">
                                                <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
                                            </form>
                            <?php
                                        }else{// 普通のいいねボタン
                                            if(!$article->flag_exist){?>
                                                <p id="right"><label>いいね！<?php echo $j;?></label></p>
                            <?php           }else{ ?>
                                                <form action="" method="post" id="right">
                                                    <input type="submit" value="いいね！<?php if($j != 0){echo $j;} ?>"
                                                    <?php if($i == 1){ ?>id="good_button"<?php } ?>>
                                                    <input type="hidden" name="from" value="good">
                                                    <input type="hidden" name="pageX" value="<?php  ?>">
                                                    <input type="hidden" name="article_id" value="<?= ($article->article_id); ?>">
                                                    <input type="hidden" name="thread_id" value="<?= h($_GET['thread_id']); ?>">
                                                    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
                                                </form>
                                <?php       }
                                        }
                                    }
                                }else{//自分の記事であるとき 
                            ?>
                                <form action="good_reference.php" method="post" id="right">
                                    <input type="submit" value="いいね！<?php if($j != 0){echo $j;} ?>"
                                    id="good">
                                    <!-- <?php if($j != 0){ ?>id="good"<?php } ?>> -->
                                    <input type="hidden" name="article_id" value="<?= h($article->article_id); ?>">
                                    <input type="hidden" name="thread_id" value="<?= h($_GET['thread_id']); ?>">
                                    <input type="hidden" name="select_thread" value="<?= h($_GET['select_thread']); ?>">
                                    <input type="hidden" name="select_thread_category" value="<?= h($_GET['select_thread_category']); ?>">
                                    <input type="hidden" name="page" value="<?= h($_GET['page']); ?>">
                                    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
                                </form>
                            <?php } ?>
                            <!-- イイネボタンend -->
                        </div>
                    <?php } ?>
            <?php endforeach; ?>
        </div>
        <!-- ここに記事出力end -->

        <!-- 投稿フォーム -->
        <form action="" method="post">
        <?php if($_SESSION['me']->email !== "guest@gmail.com"){?>
            <p id="attention"><?php if(!$_SESSION['me']->flag_reflect){ echo "反映されるまで時間がかかります！"; } ?></p>
            <p class="err"><?= h($app->getErrors('update')); ?></p>
            <p class="err"><?= h($app->getErrors('text')); ?></p>
            <label for="message">投稿</label>
            <?php if(isset($app->getValues()->quote)){?>
                <p>>><?= h($app->getValues()->quote); ?></p>
                <input type="submit" name="btn_submit" value="引用をやめる">
                <input type="hidden" name="quit" value="true">
            <?php } ?>
        </form>
        <form action="" method="post">
            <div>
                <textarea id="message" name="text"></textarea>
            </div>
            <input type="submit" name="btn_submit" value="投稿">
            <input type="hidden" name="select_thread" value="<?= h($_GET['select_thread']); ?>">
            <input type="hidden" name="select_thread_category" value="<?= h($_GET['select_thread_category']); ?>">
            <input type="hidden" name="thread_id" value="<?= h($_GET['thread_id']); ?>">
            <input type="hidden" name="page" value="<?= h($_GET['page']); ?>">
            <?php if(isset($app->getValues()->quote)){?>
                <input type="hidden" name="quote" value="<?= h($app->getValues()->quote); ?>">
            <?php } ?>
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        <?php } ?>
        <!-- 投稿フォームend -->
            <p class="fs12"><a href="/index.php">スレッド一覧</a></p>
        </form>
        <!-- ページャー -->
        <?php
            $path = "/thread.php?select_thread=".$_GET['select_thread']."&select_thread_category=".$_GET['select_thread_category']."&thread_id=".$_GET['thread_id']."&page=";
            $maxpage = ceil($app->getValues()->num_articles/$app->getValues()->show_num_page);
        ?>
        <?php 
            if($maxpage >= 1){ ?>
            <ul class="pageNav01">
                <?php if($_GET['page'] != 1){ 
                    $path_new = $path . ($_GET['page']-1);
                ?>
                    <li><a href="<?= h($path_new);?>">&laquo; 前</a></li>
                <?php } ?>
                <?php
                for($i = 0;$i < $maxpage; $i++){
                    if($i+1 == $_GET['page']){
                ?>
                        <li><span><?= h($i+1); ?></span></li>
                <?php 
                    }else{
                        $path_new = $path.($i+1);
                ?>
                        <li><a href="<?= h($path_new);?>"><?= h($i+1); ?></a></li>
                <?php 
                    } ?>
            <?php
                }
                if($_GET['page'] != $maxpage){
                    $path_new = $path . ($_GET['page']+1);
            ?>
                    <li><a href="<?= h($path_new);?>">次 &raquo;</a></li>
            <?php 
                } ?>
            </ul>
        <?php
            } ?>
        <!-- ページャーend -->

        <!-- Javascriptで自動スクロール -->
        <!-- ページの一番下に移動 -->
        <?php if(isset($app->getValues()->quote) || isset($app->getValues()->bottom)){ ?>
        <script>
        var a = document.documentElement;
        var y = a.scrollHeight - a.clientHeight;
        window.scroll(0, y);
        </script>
        
        <?php } elseif(true){?>
        <?php } ?>
        <!-- Javascriptで自動スクロールend -->
        
    </div>
</body>
</html>