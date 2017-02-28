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




