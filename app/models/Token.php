<?php
/**
 *  Token Library model
 */ 
use Phalcon\Mvc\Model;

/**
 * Token Library
 *
 * Token handler/model implementation
 * 
 * @author Ricardo Carrola <ricardo.carrola@gmail.com>
 * 
 * @since 1.0
 * 
 */ 
class Token extends model{

  /**
   * @var $token string
   */ 
  var $token;
  var $users_id;
  var $valid_until;

  public function initialize(){
          $this->setSource("tokens");
  }
  /**
   * Getter from token
   * 
   * @return string Token
   */
  public function getToken(){
    return $this->token;
  }
  /**
   * Getter for User Id associated with this token
   * 
   * @return int User Id
   */
  public function getUserId(){
    return $this->users_id;
  }
  /**
   * Getter for Token validity
   * 
   * @return int User Id
   */
  public function getValidity(){
    return $this->valid_until;
  }
  /**
   * Checks if the current token is still valid
   * if it is not valid it will remove it from the db
   * 
   * @return bool Token is valid or not
   */
  public function isValid(){
    if ($this->valid_until <= date("Y-m-d H:i:s")){
      $this->delete();
      return false;
    }
    return true;
  }
  
 /**
  *  Give a specific user this will allow generating/reusing a token from a specific User
  * 
  * @return Token The token to be used for authentication
  * @since 1.0
  */
  
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
  /*
  Generate a new token
  */
  private static function generate(){
    return uniqid(md5(date('YmdHis')), true);
  }
}
