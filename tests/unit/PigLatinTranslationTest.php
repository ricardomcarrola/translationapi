<?php

namespace tests\Unit;

/**
 * Unit testing for PigLatin Translations
 * 
 * This will make tests for covering user creation and finding
 * 
 * @covers PigLatinTranslation
 */
 
class PigLatinTranslationTest extends \UnitTestCase
{
    public function testTranslation(){
        
      $testCases = array(
        "yellow"=>"ellowyay",
        ""=>"",
        "qu"=>"quay",
        "quiet"=>"ietquay",
        "Quiet? welcome"=>"Ietquay? elcomeway",
        "What's"=>"At'swhay",
        "Quiet?"=>"Ietquay?",
        "style"=>"ylestay",
        "quiet"=>"ietquay",
        "california"=>"aliforniacay",
        "paragraphs"=> "aragraphspay",
        "glove"=>"oveglay",
        "algorithm"=> "algorithmway",
        "eight"=>"eightway",
        'Welcome'=>'Elcomeway',
        'How are you?'=>'Owhay areway ouyay?',
        'Long time no see'=>'Onglay imetay onay eesay',
        'What\'s your name?'=>'At\'swhay ouryay amenay?',
        'My name is ...'=>'Ymay amenay isway ...',
        'Where are you from?'=>'Erewhay areway ouyay omfray?',
        'I\'m from ...'=>'I\'mway omfray ...',
        'Pleased to meet you'=>'Easedplay otay eetmay ouyay',
        'Good morning'=>'Oodgay orningmay',
        'Good afternoon'=>'Oodgay afternoonway',
        'Good evening'=>'Oodgay eveningway',
        'Good night'=>'Oodgay ightnay',
        'Good bye'=>'Oodgay yebay',
        'Good luck!'=>'Oodgay ucklay!',
        'Cheers! Good Health!'=>'Eerschay! Oodgay Ealthhay!'
      );
      

     $piglatin = new \PigLatinTranslation();
     
     foreach($testCases as $word=>$translation)    
       $this->assertEquals(
            $translation,
            $piglatin->get($word)
        );
            
    }
}