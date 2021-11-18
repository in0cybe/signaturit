<?php

namespace Tests\App\Controllers;

use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\CIUnitTestCase;
// use CodeIgniter\Test\DatabaseTestTrait; // For Database Test


/**
 */
class HomeTest extends CIUnitTestCase
{
    use ControllerTestTrait;

    // For Database Test
        //use DatabaseTestTrait; 

        // protected $migrate = false; 
        // public $db;
    // For Database Test

    /**
     * This method is called before each test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // For Database Test
            // $this->db = Database::connect();
            // $this->db->transBegin();
            // $this->query = new \CodeIgniter\Database\Query($this->db);
    }

    /**
     * This method is called after each test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        // $this->db->transRollback(); // For Database Test
    }

    /**
     * Test to index function
     * In charge of showing the view for data insertion
     *
     * @return void
     */
    public function testIndex()
    {
        $result = $this->withURI('http://localhost')
            ->controller(\App\Controllers\Home::class)
            ->execute('index');

        echo " \n Info: Asserting Status in Index  \n";
        $this->assertTrue($result->isOK());
    }

    public function testFirstCase(){

        // $request = new \CodeIgniter\HTTP\IncomingRequest(new \Config\App(), new \CodeIgniter\HTTP\URI('http://localhost/Home/firstCase'), 'php://input', new \CodeIgniter\HTTP\UserAgent());
        // $response = new \CodeIgniter\HTTP\Response(new \Config\App());
        // $logger = new \Psr\Log\NullLogger();

        // $result = $this->withRequest($request)
        //     ->withResponse($response)
        //     ->withLogger($logger)
        //     ->controller(\App\Controllers\Home::class)
        //     ->execute('firstCase');

        $body = json_encode([
            'plaintiff' => [2, 5],
            'defendant' => [1, 2]
        ]);

        $result = $this->withBody($body)
        ->controller(\App\Controllers\Home::class)
        ->execute('firstCase');

        echo " \n Info: Asserting Status in FirstCase \n";

        $result->assertStatus(200);
    }
}
