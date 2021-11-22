<?php

namespace App\_Domain\BusinessLogic;

use App\Models\ModelFactory;

class WinnerlLawsuit
{

  protected $endpointModel, $requestModel, $resourcesModel, $json;

  /**
   * Instance of models through the model factory
   */
  public function __construct()
  {
    // ...
  }

  /**
   * Get and Process Pending Jobs (ordered)
   *
   * @param Json $json
   * @return String
   */
  public function startLawuit($json)
  {
    //TODO: Controlar s es casi uno o dos y
    // devolver el resultado.
  }
  



  /**
     * firstCase & secondCase Auxiliary function
     *
     * @param [type] $mode
     * @return String
     */
    private function decodedData($mode) {
      $lawsuit = [];
      $plaintiff = 0;
      $defendant = 0;
      if ($this->request->getBody()) { // view form submission
          $lawsuit = explode("&", $this->request->getBody());

          $tempPlaintiff = [];
          $tempDefendant = [];
          foreach ($lawsuit as $key => $value) {
              //if (str_contains($value, 'plaintiff')) { // Only for php 8
              if (strpos($value, 'plaintiff') !== false) { // for php 7
                  $tempPlaintiff[$key] = explode("plaintiff=", $value);
              } elseif (strpos($value, 'defendant') !== false) {
                  $tempDefendant[$key] = explode("defendant=", $value);
              }
          }

          foreach ($tempPlaintiff as $key => $value) {
              $plaintiff += intval($value[1]);
          }
          foreach ($tempDefendant as $key => $value) {
              $defendant += intval($value[1]);
          }
      } else {
          $plaintiff = array_sum(json_decode($_POST["plaintiff"]));
          $defendant = array_sum(json_decode($_POST["defendant"]));

          $lawsuit['plaintiff'] = $plaintiff;
          $lawsuit['defendant'] = $defendant;
      }

      $data = null;
      if ($mode == 'firstCase') {  // Control of the lawsuit           
          if ($plaintiff > $defendant) {
              $data = 'plaintiff';
          } elseif ($plaintiff == $defendant) {
              $data = 'tie';
          } else {
              $data = 'defendant';
          }
      }else{ // Control of the signature necessary to win
          $forWin = [1, 2, 5];
          $shortOf = '';
          if ($plaintiff < $defendant) {
              foreach($forWin as $value){
                  if ($plaintiff + $value > $defendant) {
                      $shortOf = $this->decodeSecondCase($value);
                      break;
                  }
              }
              $data = 'plaintiff short of: ' . $shortOf;
          } elseif ($plaintiff == $defendant) {                
              $data = 'tie';
          } else {
              foreach ($forWin as $value) {
                  if ($plaintiff + $value > $defendant) {
                      $shortOf = $this->decodeSecondCase($value);
                  }
              }
              $data = 'defendant short of: '. $shortOf;
          }
      }       
      
      return $data;
  }

  /**
   * Auxiliary DecodedData function
   *
   * @param String $data
   * @return Int
   */
  private function decodeSecondCase($data){
      $result = null;

      if ($data == 1) {
          $result = "V";
      }elseif($data == 2){
          $result = "N";
      }else{
          $result = "K";
      }

      return $result;
  }

}
