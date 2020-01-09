<?php

namespace MyApp\Controller;

class Add_subadmin extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }elseif(!$_SESSION['me']->flag_admin){
      header('Location: ' . SITE_URL);
      exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $this->addProcess();
    }
    
    // 入力されたemail,nicknameが初期化されないようにする
    if(isset($_POST['email'])){
      $this->setValues('email', $_POST['email']);
    }
    if(isset($_POST['nickname'])){
      $this->setValues('nickname', $_POST['nickname']);
    }
  }

  protected function addProcess(){
    // validate データの検証
    try{
      $this->_validate();
    }catch(\MyApp\Exception\InvalidEmail $e){
      $this->setErrors('email', $e->getMessage());
    }catch(\MyApp\Exception\InvalidNickname $e){
      $this->setErrors('nickname', $e->getMessage());
    }catch(\MyApp\Exception\InvalidPassword $e){
      $this->setErrors('password', $e->getMessage());
    }

    if($this->hasError()){
      $_GET['update'] = null;
      return;
    }else{
      // create admin
      try{
        $userModel = new \MyApp\Model\Admin();
        $userModel->create([
          'email' => $_POST['email'],
          'password' => $_POST['password'],
          'nickname' => $_POST['nickname']
        ]);
      }catch(\MyApp\Exception\DuplicateEmail $e){
        $this->setErrors('email', $e->getMessage());
        return ;
      }

      // redirect to add_subadmin
      header('Location: ' . SITE_URL . '/add_subadmin.php?update=true');
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
  }

}