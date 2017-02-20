<?php

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
