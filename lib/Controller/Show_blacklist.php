<?php

namespace MyApp\Controller;

class Show_blacklist extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      // login
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }elseif(!$_SESSION['me']->flag_admin){
      header('Location: ' . SITE_URL);
      exit;
    }
    
    // ブラックリスト解除
    if(isset($_POST['unlock'])){
      try{
        $blacklistModel = new \MyApp\Model\Blacklist();
        $blacklistModel->delete($_POST['email']);
      }catch(\MyApp\Exception\UpdateError $e){
        $this->setErrors('update', $e->getMessage());
        return;
      }

      // 成功したらredirect
      header('Location: ' . SITE_URL . '/show_blacklist.php'); // 自分にリダイレクト
    }

    // get blacklist info
    $blacklistModel = new \MyApp\Model\Blacklist();
    $this->setValues('blacklist', $blacklistModel->findAll());
  }

}