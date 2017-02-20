<?php
use Phalcon\Mvc\Model;

class TranslationResults extends model{

  var $id = null;
  var $key="";
  var $value="";
  var $language="";

  public function initialize(){
          $this->setSource("translation_result");
  }
  public function setKey($key){
    $this->key = $key;
  }
  public function setValue($value){
    $this->value = $value;
  }
  public function setLanguage($language){
    $this->language = $language;
  }
  public function getValue(){
    return $this->value;
  }
  static public function get($key,$language){
    $tr = TranslationResults::findFirst(array(
      "conditions"=>" key=:key: and language=:language:",
      "bind"=>array("key"=>$key,"language"=>$language)
    ));
    if ($tr)
      return $tr->getValue();
    return false;
  }
  static public function set($key="",$val="",$language=""){
    
    $tr = new TranslationResults();
    $tr->setKey($key);
    $tr->setValue($val);
    $tr->setLanguage($language);
    return $tr->save();
  }
}