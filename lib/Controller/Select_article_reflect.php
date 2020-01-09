<?php

namespace MyApp\Controller;

class Select_article_reflect extends \MyApp\Controller {
    public function run() {
        if (!$this->isLoggedIn()) {
            header('Location: ' . SITE_URL);
            exit;
        }elseif(!$_SESSION['me']->flag_admin){
            header('Location: ' . SITE_URL);
            exit;
        }
        $articleModel = new \MyApp\Model\Article();
        $res = $articleModel->findArticles(['thread_id' => $_GET['thread_id']]);
        $this->setValues('articles', $res);
        $threadModel = new \MyApp\Model\Thread();
        $this->setValues('thread', $threadModel->findThread($_GET['thread_id']));

        if(isset($_GET['reflect'])){
            $this->reflectAllTrueProcess();
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['thread_ids']) && is_array($_POST['thread_ids'])){
                foreach($_POST['thread_ids'] as $thread_id):
                    $this->reflectProcess($thread_id);
                endforeach;
                // redirect to select_article_reflect
                $url = "/select_article_reflect.php?thread_id=".$_GET['thread_id'];
                header('Location: ' . SITE_URL . $url);
                exit;
            }
        }
    }

    protected function reflectProcess($article_id){
        try{
            $articleModel = new \MyApp\Model\Article();
            $article = $articleModel->findArticle([
                'thread_id' => $_GET['thread_id'],
                'article_id' => $article_id
            ]);
            $articleModel->update_flag_reflect([
              'article_id' => $article_id,
              'thread_id' => $_GET['thread_id'],
              'flag_reflect' => $article->flag_reflect
            ]);
        }catch(\MyApp\Exception\FindError $e){
            $this->setErrors('find', $e->getMessage());
            return ;
        }
    }
    
    protected function reflectAllTrueProcess(){
        try{
            $articleModel = new \MyApp\Model\Article();
            $articles = $articleModel->findArticles_flag_reflect0([
                'thread_id' => $_GET['thread_id']
            ]);
            foreach($articles as $article):
                $articleModel->update_flag_reflect([
                'article_id' => $article->article_id,
                'thread_id' => $_GET['thread_id'],
                'flag_reflect' => $article->flag_reflect
                ]);
            endforeach;
        }catch(\MyApp\Exception\FindError $e){
            $this->setErrors('find', $e->getMessage());
            return ;
        }
      
        // redirect to select_article_reflect
        $url = "/select_article_reflect.php?thread_id=".$_GET['thread_id'];
        header('Location: ' . SITE_URL . $url);
        exit;
    }
}