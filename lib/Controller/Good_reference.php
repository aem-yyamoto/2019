<?php

namespace MyApp\Controller;

class Good_reference extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      // login
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }

    $this->setValues('thread_id',$_POST['thread_id']);
    $this->setValues('article_id',$_POST['article_id']);
    $this->setValues('select_thread',$_POST['select_thread']);
    $this->setValues('select_thread_category',$_POST['select_thread_category']);
    $this->setValues('page',$_POST['page']);

    // get goods info
    $goodModel = new \MyApp\Model\Good();
    $this->setValues('goods', $goodModel->findGoods_article(['thread_id' => $_POST['thread_id'],'article_id' => $_POST['article_id']]));
    
    // get threads info
    $threadModel = new \MyApp\Model\Thread();
    $this->setValues('threads', $threadModel->findAll());
    
  }

}