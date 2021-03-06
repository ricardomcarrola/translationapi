<?php

/**
  * Generic stuff about Translation comes here!
  */
abstract Class Translation{
  use Cacheable;

  var $language;

  function __construct($language='PigLatin'){
    $this->language = $language;

  }
  /* Get a specified translation */
  public abstract function get($text);

  protected final function doRequest($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }
}
/**
  * Adds caching power to the translation api
  */
trait Cacheable {
  function isCacheEnabled(){
    $config = Phalcon\DI::getDefault()->get("config");
    return $config->cache_translations->enable;
  }
  function isCached($key,$language){
    if (!$this->isCacheEnabled())
      return false;
    return TranslationResults::get($key,$language);
  }
  function fromCache($key,$language) {
    if (!$this->isCacheEnabled())
      return false;
    return TranslationResults::get($key,$language);
  }
  function toCache($key,$language,$value) {
    if (!$this->isCacheEnabled())
      return false;
    return TranslationResults::set($key,$value,$language);
  }
}
