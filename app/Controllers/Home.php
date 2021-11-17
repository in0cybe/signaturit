<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
/**
 * A simple class of online judgment to earn money with Saul
 * ;)
 */
class Home extends BaseController
{

    /**
     * Access to the main view
     * In this view the Winner Function arguments are established
     *
     * @return void
     */
    public function index()
    {
        return view('welcome_message');
    }


    /**
     * Set the winner of the lawsuit for the first case
     *
     * @return mixed
     */
    public function firstCase()
    {
        $this->logger->info("[" . __METHOD__ . "] -> Entering...");
        try {
            $data = ['result' => $this->decodedData('firstCase')];
            // Return the data to the view
            return view('winner_message', $data);            

        } catch (\Exception $e) {
            $this->logger->debug("[" . __METHOD__ . "] -> Exception: " . json_encode($e));
            return false;
        }        
    }


    /**
     * Set the winner of the lawsuit for the second case
     *
     * @return mixed
     */
    public function secondCase(){
        $this->logger->info("[" . __METHOD__ . "] -> Entering...");
        try {
            $data = ['result' => $this->decodedData(null)];            
            // Return the data to the view
            return view('winner_message', $data);  

        } catch (\Exception $e) {
            $this->logger->debug("[" . __METHOD__ . "] -> Exception: " . json_encode($e));
            return false;
        } 

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
