<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;

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
     * @param array $plaintiff
     * @param array $defendant
     * @return void
     */
    public function winner()
    {
        helper('url');
        $this->logger->info("[" . __METHOD__ . "] -> Entering...");

        try {
            $lawsuit = [];
            if ($this->request->getBody()) { // view form submission
                $lawsuit = explode("&", $this->request->getBody());
                $res = [];
                foreach ($lawsuit as $key => $value) {
                    //if (str_contains($value, 'plaintiff')) { // Only for php 8
                    if (strpos($value, 'plaintiff') !== false) { // php 7
                        $res['plaintiff'][$key] = explode("plaintiff=", $value);
                    } elseif (strpos($value, 'defendant') !== false) {
                        $res['defendant'][$key] = explode("defendant=", $value);
                    }
                }
                $kk = array_sum($res['plaintiff']);
                array_sum($res['defendant']);
            } else { // HTTP request
                $plaintiff = array_sum(json_decode($_POST["plaintiff"]));
                $defendant = array_sum(json_decode($_POST["defendant"]));

                $lawsuit['plaintiff'] = $plaintiff;
                $lawsuit['defendant'] = $defendant;
            }


            $data = ['result' => null];
            if (array_sum($plaintiff) > array_sum($defendant)) {
                $data["result"] = 'defendant';
            } elseif (array_sum($plaintiff) == array_sum($defendant)) {
                $data["result"] = 'tie';
            } else {
                $data["result"] = 'plaintiff';
            }

            // Return the data to the view
            return view('winner_message', $data);

        } catch (\Exception $e) {
            $this->logger->info("[" . __METHOD__ . "] -> Exception: " . json_encode($e));
            return false;
        }

        
    }
}
