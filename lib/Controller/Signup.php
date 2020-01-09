<?php

namespace MyApp\Controller;

class Signup extends \MyApp\Controller {

  public function run() {
    if ($this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $this->postProcess();
    }
  }

  protected function postProcess(){
    // validate データの検証
    try{
      $this->_validate();
    }catch(\MyApp\Exception\InvalidEmail $e){
      $this->setErrors('email', $e->getMessage());
    }catch(\MyApp\Exception\InvalidNickname $e){
      $this->setErrors('nickname', $e->getMessage());
    }catch(\MyApp\Exception\InvalidPassword $e){
      $this->setErrors('password', $e->getMessage());
    }catch(\MyApp\Exception\InBlacklist $e){
      $this->setErrors('blacklist', $e->getMessage());
    }

    $this->setValues('email', $_POST['email']);
    $this->setValues('nickname', $_POST['nickname']);

    if($this->hasError()){
      return;
    }else{
      // create user
      try{
        $userModel = new \MyApp\Model\User();
        $userModel->create([
          'email' => $_POST['email'],
          'password' => $_POST['password'],
          'nickname' => $_POST['nickname']
        ]);
      }catch(\MyApp\Exception\DuplicateEmail $e){
        $this->setErrors('email', $e->getMessage());
        return ;
      }

      // redirect to login
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }
  }

  private function _validate(){
    $this->validate_token();
    
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
      throw new \MyApp\Exception\InvalidEmail();
    }
    // nicknameの例外処理
    if($_POST['nickname'] === ""){
      throw new \MyApp\Exception\InvalidNickname();
    }
    if(!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['password'])){
      throw new \MyApp\Exception\InvalidPassword();
    }
    // ブラックリストの検証
    $blacklistModel = new \MyApp\Model\Blacklist();
    $res = $blacklistModel->findUser($_POST['email']);
    if($res !== false){
      throw new \MyApp\Exception\InBlacklist();
    }
  }

}