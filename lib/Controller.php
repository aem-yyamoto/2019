<?php

namespace MyApp;

class Controller {
  private $_errors; // クラス（オブジェクト）
  private $_values; // クラス（オブジェクト） viewと値の受け渡しに使う


  public function __construct(){
    if(!isset($_SESSION['token'])){
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
    $this->_errors = new \stdClass(); // stdClass:PHPデフォルトのクラス
    $this->_values = new \stdClass();
  }

  protected function setValues($key, $value){
    $this->_values->$key = $value;
  }

  public function getValues(){
    return $this->_values;
  }

  protected function setErrors($key, $error){
    $this->_errors->$key = $error;
  }

  public function getErrors($key){
    return isset($this->_errors->$key) ? $this->_errors->$key : '';
  }

  protected function hasError(){
    return !empty(get_object_vars($this->_errors));
  }

  protected function isLoggedIn() {
    // $_SESSION['me']
    return isset($_SESSION['me']) && !empty($_SESSION['me']);
  }

  // loginしているユーザーの情報を取得
  public function me(){
    return $this->isLoggedIn() ? $_SESSION['me'] : null;
  }

  public function validate_token(){
    if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
      echo "Invalid Token!";
      exit;
    }
  }

}