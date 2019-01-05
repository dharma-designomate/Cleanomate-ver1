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
class Payment extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('car_M');
		$this->load->model('customer_M');
		$this->load->model('payment_M');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_post']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

	public function payment_post() {
	   $status=$this->verify_key($this->post('key'));
	   if($status) {
		$ch = curl_init();
		$clientId = "AV8zKhkIV-9Dftl3EjU0FqKM1i97qiwwOgEB11PXRmSMfLypyXuWLGycJ0sGZZbBmIaNxqYUQVKH0MNR";
		$secret = "ELX7PxATCrKFCmvE1Ue8TEOx4wkc_A53XtHmgG2n0CvC7ulR6vakXEUmn4jX2um_KfzfGdYJ3RrqpS4_";

		curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

		$result = curl_exec($ch);

		if(empty($result))die("Error: No response.");
		else
		{
			$json = json_decode($result);
			//print_r($json->access_token);
			$this->response([
                    'status' => REST_Controller::HTTP_OK,
                    'message' => $json
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			
		}

		curl_close($ch);
	  
	   } else {
		    $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect API key'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
	   }
	   }
	   
	   public function addInfo_post() {
	   $status=$this->verify_key($this->post('key'));
	   if($status) {
	   $info=$this->post();
	   $info['customer_id']=$this->customer_M->create($info);
	   $info['car_id']=$this->car_M->addInfo($info);
	   $info['transaction_id']=$this->payment_M->addInfo($info);
	   $info=$this->invoice_M->addInfo($info);
	   if(!empty($info)) {
	   $info1['msg']= 'Updated';
	   $info1['status']=  REST_Controller::HTTP_OK;
	   $this->response($info1, REST_Controller::HTTP_OK);
	   }
	    else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect ID'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            } 
	   } else {
		    $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect API key'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
	   }
	   }
	   
	   public function update_post() {
	   $status=$this->invoice_M->verify_key($this->post('key'));
	   if($status) {
	   $id=$this->post();
	   $info=$this->invoice_M->update($id);
	   if(!empty($info)) {
	   $info1['msg']= 'Updated';
	   $info1['status']=  REST_Controller::HTTP_OK;
	   $this->response($info1, REST_Controller::HTTP_OK);
	   }
	    else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect ID'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            } 
	   } else {
		    $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect API key'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
	   }
	   }
	   
	    public function invoiceList_post() {
	   $status=$this->invoice_M->verify_key($this->post('key'));
	   if($status) {

	   $info=$this->invoice_M->viewList($this->post());
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

