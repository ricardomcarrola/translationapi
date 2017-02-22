<?php

/**
 * TranslationFactory Class
 * 
 * This class allows to wrap around several implementations of translations acting as a Factory
 * 
 * @author  Ricardo Carrola <ricardo.carrola@gmail.com>
 * @copyright 2017 - Carrola
 * @since 1.0
 *
 */
class TranslationFactory{

  static function get($language){
      switch (strtolower($language)){
        case 'piglatin' :
            return new PigLatinTranslation($language);
        default :
            return new DefaultTranslation($language);
      }
      return new $language->getTranslationClass();
  }

}

/**
 * DefaultTranslation Class
 * 
 * This class currently olds the default implementation for the "default" translation by using a free rest webservice for translating strings
 * 
 * @author  Ricardo Carrola <ricardo.carrola@gmail.com>
 * @copyright 2017 - Carrola
 * @since 1.0
 *
 */
class DefaultTranslation extends Translation{

    
    function get($text){
      if (!$text)
        return "";
      $config = Phalcon\DI::getDefault()->get("config");
      if ($this->isCached($text,$this->language))
        return $this->fromCache($text,$this->language);

      /* RC: Isolating stuff from this method */
      $data = json_decode($this->doRequest(
        $config->translations->service_uri."?text=".urlencode($text)."&to=".$this->language
      ));

      $this->toCache($text,$this->language,$data->translationText);
      return $data->translationText;
    }
}