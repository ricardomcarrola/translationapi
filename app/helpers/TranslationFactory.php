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
 * This class currently holds the default implementation for the "default" translation by using a free rest webservice for translating strings
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


/**
 * PigLatinTranslation Class
 * 
 * This class currently holds the implementation for the piglatin translation
 * 
 * @author  Ricardo Carrola <ricardo.carrola@gmail.com>
 * @copyright 2017 - Carrola
 * @since 1.0
 *
 */
class PigLatinTranslation extends Translation{
  
  function get($text){
    
    $isAWord = false;
    return $this->translateWord($text);
    
  
  }
  
  /**
   * 
   * Source @https://en.wikipedia.org/wiki/Pig_Latin
   */
  private function translateWord($word){
      if ($this->isVowel($word[0])){
        return $word."way";
      }else{
        $word = str_split($word);
        foreach($word as $i=>$letter){
          if ($this->isVowel($letter,'/[a|e|i|o|u|y]/')){
            return implode("",$word)."ay";
          }else{ 
            if ($this->isValidLetter($letter)){
              if (strtolower($word[$i+1])=='u' && strtolower($letter)=='q'){
                $word[] = $letter;
                $word[] = $word[$i+1];
                unset($word[$i]);
                unset($word[++$i]);
              }
              else{
                $word[] = $letter;
                unset($word[$i]);  
              }
            } 
          }
        }
        return implode("",$word);
      }

  }
  private function testRegex($re,$text){
      preg_match_all($re, strtolower($text), $matches,PREG_SET_ORDER);
        return count($matches);
  }
  private function isVowel($text,$re = '/[a|e|i|o|u]/'){
      return $this->testRegex($re,$text);
  }
  
  private function isValidLetter($text,$re = '/[a-z|A-Z]/'){
      return $this->testRegex($re,$text);
  }
}