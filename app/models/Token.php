<?php

use Phalcon\Mvc\Model;

class Token extends model{

  var $token;
  var $users_id;
  var $valid_until;

  public function initialize(){
          $this->setSource("tokens");
  }
  public function getToken(){
    return $this->token;
  }
  public function getUserId(){
    return $this->users_id;
  }
  public function isValid(){
    if ($this->valid_until <= date("Y-m-d H:i:s")){
      $this->delete();
      return false;
    }
    return true;
  }
  public function getValidity(){
    return $this->valid_until;
  }

  static public function getTokenForUser(Users $user){
    if (!$user)
      return false;

    $config = Phalcon\DI::getDefault()->get("config");

    //RC: T1 : Token exists retrieve it
    $token = Token::findFirst(array(
      "conditions"=>("users_id = :users_id:"),
      "bind"=>array("users_id"=>$user->getId())
    ));
    //RC: T2 : Token does not exists create
    if (!$token){
      $token = new Token();
      $token->setToken($user->getId(),self::generate(),$config->tokens->validity);
      if (!$token->save()){
        $messages = $token->getMessages();
        throw new Exception(implode(",",$messages));
      }
    }
    return $token;
  }

  private function setToken($userid='',$token='',$valid_until='1 Hours'){
    $this->token = $token;
    $this->users_id  = $userid;
    $this->valid_until = date("Y-m-d H:i:s", strtotime('+ '.$valid_until));
  }

  private static function generate(){
    return uniqid(md5(date('YmdHis')), true);
  }
}
