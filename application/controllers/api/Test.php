<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Test extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('test_M');
		
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_post']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

	
	    public function testList_post() {
	   $status=$this->test_M->verify_key($this->post('key'));
	   if($status) {

	   $info=$this->test_M->viewList($this->post());
	   if(!empty($info)) {
	   $info1['info']= $info;
	   $info1['status']=  REST_Controller::HTTP_OK;
	   $this->response($info1, REST_Controller::HTTP_OK);
	   }
	    else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            } 
	   } else {
		    $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect API key'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
	   }
	   }
	   
	  
	public function verify_key($key) {
		if($key=='t1E1a6p3j2') {
			return true;
		}
		else {
			return false;
		}
	}
}

