<?php

namespace tests\Unit;

/**
 * Unit testing for PigLatin Translations
 * 
 * This will make tests for covering user creation and finding
 * 
 * @covers PigLatinTranslation
 */
 
class TranslationTest extends \UnitTestCase
{
    public function testTranslation(){
        
      $textStrings = array(
           "yellow",
           "style"
          
      );
      $expectedResults = array(
          "elloyay",
          "ylestay"
      );
     $piglatin = new \PigLatinTranslation();
     foreach($textStrings as $k=>$val)    
       $this->assertEquals(
            $expectedResults[$k],
            $piglatin->get($val)
        );
            
    }
}