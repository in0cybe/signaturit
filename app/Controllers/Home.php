<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
/**
 * A simple kind of online judgment to earn money with Saul
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
     * Set the winner of the lawsuit
     *
     * @return mixed
     */
    public function winner()
    {
        helper('url');
        $this->logger->info("[" . __METHOD__ . "] -> Entering...");

        try {
            $lawsuit = [];
            $plaintiff = 0;
            $defendant = 0;
            if ($this->request->getBody()) { // view form submission
                $lawsuit = explode("&", $this->request->getBody());

                $tempPlaintiff = [];
                $tempDefendant = [];
                foreach ($lawsuit as $key => $value) {
                    //if (str_contains($value, 'plaintiff')) { // Only for php 8
                    if (strpos($value, 'plaintiff') !== false) { // php 7
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
            } else { // HTTP request
                $plaintiff = array_sum(json_decode($_POST["plaintiff"]));
                $defendant = array_sum(json_decode($_POST["defendant"]));

                $lawsuit['plaintiff'] = $plaintiff;
                $lawsuit['defendant'] = $defendant;
            }

            $data = ['result' => null];     
            // Control of the lawsuit
            if ($plaintiff > $defendant) {
                $data["result"] = 'defendant';
            } elseif ($plaintiff == $defendant) {
                $data["result"] = 'tie';
            } else {
                $data["result"] = 'plaintiff';
            }

            // Return the data to the view
            return view('winner_message', $data);            

        } catch (\Exception $e) {
            $this->logger->debug("[" . __METHOD__ . "] -> Exception: " . json_encode($e));
            return false;
        }        
    }
}
