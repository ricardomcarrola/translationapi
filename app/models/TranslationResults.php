<?php
/**
 * Translation Cache Model
 */
 
use Phalcon\Mvc\Model;

/**
 * Translation Cache Library
 *
 * Handles caching the results
 * 
 * @author Ricardo Carrola <ricardo.carrola@gmail.com>
 * 
 * @since 1.0
 * 
 */ 
class TranslationResults extends model{
  
  /** @var int|null auto-increment id*/
  var $id = null;
  /** @var string key */
  var $key="";
  /** @var string value */
  var $value="";
  /** @var string language*/
  var $language="";

  /**
   * Method for allocating the right table
   */ 
  public function initialize(){
          $this->setSource("translation_result");
  }
  /**
   * Setter for the key
   * 
   * @param string $key
   */ 
  public function setKey($key){
    $this->key = $key;
  }
  /**
   * Setter for the value
   *
   * @param string $value
   */
  public function setValue($value){
    $this->value = $value;
  }
  /**
   * Setter for the language
   * 
   * @param string $language
   */
  public function setLanguage($language){
    $this->language = $language;
  }
  /**
   * Getter for the language
   */ 
  public function getValue(){
    return $this->value;
  }
  /** 
   * Truncate full table
   */ 
  public function truncate() {
    $this->getDi()->getShared('db')->query("truncate table ".$this->getSource());
 }
 /**
  * Get translation associated with the key+language combination
  * 
  * @param string $key
  * @param string $language
  * 
  * @since 1.0
  */
  static public function get($key,$language){
    $tr = TranslationResults::findFirst(array(
      "conditions"=>" key=:key: and language=:language:",
      "bind"=>array("key"=>$key,"language"=>$language)
    ));
    if ($tr)
      return $tr->getValue();
    return false;
  }
  /**
  * Set the translation associated with the key+language combination
  * 
  * @param string $key
  * @param string $val
  * @param string $language
  * 
  * @since 1.0
  */
  static public function set($key="",$val="",$language=""){
    
    $tr = new TranslationResults();
    $tr->setKey($key);
    $tr->setValue($val);
    $tr->setLanguage($language);
    return $tr->save();
  }
}
