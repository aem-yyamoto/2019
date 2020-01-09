<?php

namespace MyApp\Controller;

class Blacklist extends \MyApp\Controller {

  public function run() {
    // get users info
    $userModel = new \MyApp\Model\User();
    $this->setValues('users', $userModel->findAll());

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      if(isset($_POST['form']) && $_POST['form'] === "blacklist"){
        $this->add_blacklist();
        $this->unsubscribe();

        header('Location: ' . SITE_URL . '/admin_show_users.php'); // admin_show_users.phpに戻る
      }
    }
  }

  private function add_blacklist(){
    $blacklistModel = new \MyApp\Model\Blacklist();
    $blacklistModel->create(['user_id' => $_POST['user_id']]);
  }

  private function unsubscribe(){
    try{
      // DB usersからユーザー情報を削除
      $userModel = new \MyApp\Model\User();
      $userModel->delete([
        'email' => $_POST['user_id']
      ]);

      // DB articlesとgoodsのflag_existをFalseにする
      $articleModel = new \MyApp\Model\Article();
      $articleModel->subscribe([
        'email' => $_POST['user_id']
      ]);
      $goodModel = new \MyApp\Model\Good();
      $goodModel->subscribe([
        'email' => $_POST['user_id']
      ]);
    }catch(\MyApp\Exception\NotEmail $e){
      $this->setErrors('email', $e->getMessage());
      return ;
    }
  }

}