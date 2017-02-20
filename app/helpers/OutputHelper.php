<?php

/**
  * OutputHelper Class
  *
  * Allows to format the output of the api.
  * Formats supported XML and JSON
  *
  * @author  Ricardo Carrola <ricardo.carrola@gmail.com>
  * @copyright 2017 - Carrola
  * @since 1.0
  *
  */

class OutputHelper{
  var $errors=array();
  var $results = null;

  function __construct($errors=array(),$results=null){
    $this->errors = $errors;
    $this->results = $results;
  }

 /**
  * Sets the list of errors for displaying on the right output format
  * @param string $errors String containing the trouble found :(
  */
  public function setErrors($errors){
    $this->errors[] = $errors;
  }
  /**
   * Sets the list of results to be returned to the user
   * @param mixed $results Results to be displayed. Mixed types allowed
   */
  public function setResults($results){
    $this->results = $results;
  }
  private function array_to_xml( $data, &$xml_data ) {
    foreach( $data as $key => $value ) {
        if( is_numeric($key) ){
            $key = 'item'.$key; //dealing with <0/>..<n/> issues
        }
        if( is_array($value) ) {
            $subnode = $xml_data->addChild($key);
            $this->array_to_xml($value, $subnode);
        } else {
            $xml_data->addChild("$key",htmlspecialchars("$value"));
        }
     }
  }

  /**
  * Output helper send method
  *
  * * Sends the current ouput errors + results
  *
  * The section after the description contains the tags; which provide
  * structured meta-data concerning the given element.
  *
  * @param string $type one of "json" or "xml"
  */
  public function send($type="json"){
    if ($type=="json"){
      echo json_encode(array(
        "result"=>$this->results,
        "errors"=>$this->errors
      ));
    }
    if ($type=="xml"){
      $xml_data = new SimpleXMLElement('<?xml version="1.0"?><api></api>');
      $this->array_to_xml(array(
        "result"=>$this->results,
        "errors"=>$this->errors
      ), $xml_data);
      print $xml_data->asXML();
    }
  }
}
