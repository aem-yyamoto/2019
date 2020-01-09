<?php

namespace MyApp\Controller;

class Login extends \MyApp\Controller {

  private function _validate(){
    $this->validate_token();

    if(!isset($_POST['email']) || !isset($_POST['password'])){
      echo "Invalid Form!";
      exit;
    }

    if($_POST['email'] === '' || $_POST['password'] === ''){
      throw new \MyApp\Exception\EmptyPost();
    }
  }

}