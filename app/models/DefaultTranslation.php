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

    
    function get($text,$force=false){
      if (!$text)
        return "";
      $config = Phalcon\DI::getDefault()->get("config");
      if ($this->isCached($text,$this->language) && !$force)
        return $this->fromCache($text,$this->language);

      /* RC: Isolating stuff from this method */
      $data = json_decode($this->doRequest(
        $config->translations->service_uri."?from=auto&text=".urlencode($text)."&to=".$this->language
      ));
    print_r($data);
      $this->toCache($text,$this->language,$data->translationText);
      return $data->translationText;
    }
    
}