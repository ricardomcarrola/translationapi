<?php 
/**
 * PigLatinTranslation Class
 * 
 * This class currently holds the implementation for the piglatin translation algorithm
 * 
 * @author  Ricardo Carrola <ricardo.carrola@gmail.com>
 * @copyright 2017 - Carrola
 * @since 1.0
 *
 */
class PigLatinTranslation extends Translation{
  
  var $splitter = array(" ","-");
  
  function get($sentence){
    
     if (!$sentence || $sentence=="")
      return "";
     $config = Phalcon\DI::getDefault()->get("config");
      if ($this->isCached($sentence,$this->language))
        return $this->fromCache($sentence,$this->language);
        
    $word = array();
    $letters = str_split($sentence);
    $result = "";
    $counter=0;
    $last_letter = strlen($sentence);
    foreach($letters as $letter){
        if ($this->isValidLetter($letter,"/[a-z|A-Z|']/"))
            $word[]=$letter;
        $counter++;
        if (in_array($letter,$this->splitter) || $counter==$last_letter || !$this->isValidLetter($letter,"/[a-z|A-Z|']/")){
            $result.=$this->translateWord(implode("",$word)) . (!$this->isValidLetter($letter) ? $letter : "");
            $word = array();
        }
    }
    $this->toCache($sentence,$this->language,$result);
    return $result;

  }
  /**
   * Calculate for every word the right translation
   */
  private function translateWord($word){
      $word=trim($word);
      if (!$word || !strlen($word))
        return "";
      
      if ($this->isVowel($word[0])){
        return $word."way";
      }else{
        $word = str_split($word);
        $first=true;
        $caps=false;
        foreach($word as $i=>$letter){
          if (!$first && $this->isVowel($letter,'/[a|e|i|o|u|y]/')){
            return $this->capFirstLetter(implode("",$word)."ay",$caps);
          }else{
            if ($first && $this->isUpperCase($letter))
                $caps=true;
            if ($this->isValidLetter($letter)){
              //move the letter to the end of the word
              if ( (count($word)>$i+1) && strtolower($word[$i+1])=='u' && strtolower($letter)=='q'){
                $word[] = ($caps && $first) ? strtolower($letter) : $letter;
                $word[] = ($caps && $first) ? strtolower($word[$i+1]) : $word[$i+1];
                unset($word[$i]);
                unset($word[++$i]);
              }
              else{
                $word[] = ($caps && $first) ? strtolower($letter) : $letter;
                unset($word[$i]);  
              }
            } 
          }
          $first=false;
        }
        return $this->capFirstLetter(implode("",$word),$caps);
      }

  }
  
  private function capFirstLetter($text,$cap=true){
      if ($cap)
        return ucfirst($text);
      else
        return $text;
  }
  private function testRegex($re,$text){
      preg_match_all($re, ($text), $matches,PREG_SET_ORDER);
      return count($matches);
  }
  private function isVowel($text,$re = '/[a|e|i|o|u]/'){
      return $this->testRegex($re,strtolower($text));
  }
  
  private function isValidLetter($text,$re = '/[a-z|A-Z]/'){
      return $this->testRegex($re,$text);
  }
   private function isUpperCase($text,$re = '/[A-Z]/'){
      return $this->testRegex($re,$text);
  }
}