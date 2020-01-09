<?php

namespace MyApp\Controller;

class Thread extends \MyApp\Controller {
    public function run() {
        if (!$this->isLoggedIn()) {
            header('Location: ' . SITE_URL);
            exit;
        }
        // pageの初期化
        if(!isset($_GET['page'])){
            $path = "/thread.php?select_thread=".$_GET['select_thread']."&select_thread_category=".$_GET['select_thread_category']."&thread_id=".$_GET['thread_id']."&page=1";
            header('Location: ' . SITE_URL .$path);
            exit;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['from']) && $_POST['from'] === "good"){
                $this->good();
            }elseif(isset($_POST['from']) && $_POST['from'] === "quote"){
                $this->setValues('quote', $_POST['article_id']);
            }elseif(isset($_POST['quit'])){
                // 引用の取り消しは、何もせずに戻る
            }else{
                $this->postProcess();
            }
        }
        
        // get pager_setting info
        $pagerModel = new \MyApp\Model\Pager_setting();
        $show_num_page = $pagerModel->getSetting()->show_num;
        $this->setValues('show_num_page',$show_num_page);

        // get threads info
        $threadModel = new \MyApp\Model\Thread();
        $this->setValues('threads', $threadModel->findAll());

        // get articles info
        $articleModel = new \MyApp\Model\Article();
        $num_articles = count($articleModel->findArticles_isreflect($_GET['thread_id'])); // そのスレッドにける記事の総数
        $this->setValues('num_articles', $num_articles);
        $this->setValues('allarticle_thread', $articleModel->findArticles(['thread_id' => $_GET['thread_id']]));

        // calculate pager
        $maxpage = ceil($this->getValues()->num_articles/$this->getValues()->show_num_page); // 総ページ数
        $this->setValues('maxpage', $maxpage);

        $offset = $num_articles - ($show_num_page*$_GET['page']);
        if($offset >= 0){
            $this->setValues('articles', $articleModel->findArticles_limit_isreflect(
                [
                    'thread_id' => (int)$_GET['thread_id'],
                    'num' => (int)$show_num_page,
                    'start' => $offset
            ]));
        }else{
            $this->setValues('articles', $articleModel->findArticles_limit_isreflect(
                [
                    'thread_id' => (int)$_GET['thread_id'],
                    'num' => (int)$show_num_page+$offset,
                    'start' => (int)0
            ]));
        }

        // get goods info
        $goodModel = new \MyApp\Model\Good();
        $this->setValues('goods_thread', $goodModel->findGoods_thread(
            [
                'thread_id' => $_GET['thread_id']
            ] ));
        if(isset($_GET['bottom'])){
            $this->setValues('bottom', $_GET['bottom']);
        }
    }

    protected function postProcess(){
        // validate データの検証
        try{
          $this->_validate();
        }catch(\MyApp\Exception\InvalidText $e){
          $this->setErrors('text', $e->getMessage());
        }
    
        $this->setValues('text', $_POST['text']);

        if($this->hasError()){
            return;
        }else{
            try{
                // create article
                $threadModel = new \MyApp\Model\Thread();
                $num_post = $threadModel->findThread($_POST['thread_id'])->num_post;

                $userModel = new \MyApp\Model\User();
                $user_num_post = $userModel->findUser($_SESSION['me']->email)->num_post;

                $articleModel = new \MyApp\Model\Article();
                $articleModel->create([
                    'article_id' => $num_post+1,
                    'thread_id' => $_POST['thread_id'],
                    'created_user_id' => $_SESSION['me']->email,
                    'text' => $_POST['text'],
                    'quote_article_id' => isset($_POST['quote'])?$_POST['quote']:null,
                    'flag_reflect' => $_SESSION['me']->flag_reflect,
                    'nickname' => $_SESSION['me']->nickname
                ]);

                // 投稿したスレッドの投稿数を更新
                $update_thread = new \MyApp\Controller\Threads();
                $update_thread->update_num_post($num_post+1, $_POST['thread_id']);

                // 投稿したユーザーの投稿数を更新
                $userModel->update_num_post([
                    'num_post' => $user_num_post+1,
                    'email' => $_SESSION['me']->email
                ]);
            }catch(\MyApp\Exception\InvalidText $e){
                $this->setErrors('text', $e->getMessage());
                return ;
            }

            // redirect to each thread
            $path = "/thread.php?select_thread=".$_POST['select_thread']."&select_thread_category=".$_POST['select_thread_category']."&thread_id=".$_POST['thread_id']."&page=1";
            $path = $path."&bottom=true";
            header('Location: ' . SITE_URL .$path);
            exit;
          }
    }

    private function good(){
        $articleModel = new \MyApp\Model\Article();
        $res = $articleModel->findArticle(['article_id' => $_POST['article_id'],'thread_id' => $_POST['thread_id']]);
        $goodModel = new \MyApp\Model\Good();
        $res_good = $goodModel->findGood(['article_id' => $_POST['article_id'],'thread_id' => $_POST['thread_id'], 'from_user_id' => $_SESSION['me']->email]);
        // article_idとthread_idでいいねをしたか判定
        if($res_good === false){
            try{
                if($res === false){throw new \MyApp\Exception\UpdateError();return;}
                $goodModel->create([
                    'article_id' => $_POST['article_id'],
                    'thread_id' => $_POST['thread_id'],
                    'from_user_id' => $_SESSION['me']->email,
                    'to_user_id' => $res->created_user_id
                ]);
                
                // userのいいね合計数を増やす
                $this->update_total_good(1, $res->created_user_id);
            }catch(\MyApp\Exception\UpdateError $e){
                $this->setErrors('update', $e->getMessage());
                return ;
            }
        }else{
            try{
                if($res === false){throw new \MyApp\Exception\UpdateError();return;}
                if($res_good->flag_exist){
                    $goodModel->delete([
                        'article_id' => $_POST['article_id'],
                        'thread_id' => $_POST['thread_id'],
                        'from_user_id' => $_SESSION['me']->email
                    ]);
    
                    // userのいいね合計数を減らす
                    $this->update_total_good(-1, $res->created_user_id);
                }else{
                    $goodModel->create([
                        'article_id' => $_POST['article_id'],
                        'thread_id' => $_POST['thread_id'],
                        'from_user_id' => $_SESSION['me']->email,
                        'to_user_id' => $res->created_user_id
                    ]);
                    
                    // userのいいね合計数を増やす
                    $this->update_total_good(1, $res->created_user_id);
                }
            }catch(\MyApp\Exception\UpdateError $e){
                $this->setErrors('update', $e->getMessage());
                return ;
            }
        }
    }

    private function update_total_good($x, $who_email){
        $userModel = new \MyApp\Model\User();
        $userModel->update_total_good([
            'total_good' => $userModel->findUser($who_email)->total_good+$x,
            'email' => $who_email
        ]);
    }

    private function _validate(){
        $this->validate_token();
        
        if(empty($_POST['text'])){
            if(isset($_POST['quote'])){
                $this->setValues('quote', $_POST['quote']);
            }
            $this->setValues('bottom',true);
            throw new \MyApp\Exception\InvalidText();
        }
    }
}