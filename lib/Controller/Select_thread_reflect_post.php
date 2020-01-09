<?php

namespace MyApp\Controller;

class Select_thread_reflect_post extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }elseif(!$_SESSION['me']->flag_admin){
      header('Location: ' . SITE_URL);
      exit;
    }
    // get threads info
    $threadModel = new \MyApp\Model\Thread();
    $this->setValues('threads', $threadModel->findAll());

    // get articles info
    $articleModel = new \MyApp\Model\Article();
    foreach($this->getValues()->threads as $thread):
      $res = $articleModel->findArticles_flag_reflect0(['thread_id'=>$thread->thread_id]);
      if($res === false)
        $this->setValues($thread->thread_id, 0);
      else
        $this->setValues($thread->thread_id, count($res));
    endforeach;

  }

}