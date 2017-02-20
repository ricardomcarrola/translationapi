<?php
use Phalcon\Mvc\Model;

class Users extends model{

  var $username=null;
  var $id = null;
  var $token = null;

  public function initialize(){
          $this->setSource("users");
  }
  static public function getUser($id=null,$pass=null,$userid=null){
    $user = false;

    //RC: fetch by user and password
    if ($id && $pass)
      $user = Users::findFirst(array(
        "conditions"=>("username = :username: and password = :password:"),
        "bind"=>array("username"=>$id,"password"=>md5($pass))
      ));
    //RC: Fetch by user id
    if ($userid)
     $user = Users::findFirstById($userid);

    return $user;
  }

 function getUserName(){
    return $this->username;
 }
 function getId(){
    return $this->id;
 }
}
