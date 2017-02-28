<?php 
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