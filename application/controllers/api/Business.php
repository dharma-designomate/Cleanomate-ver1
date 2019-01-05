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
class Business extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('business_M');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_post']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

	public function login_post() {
	   $status=$this->business_M->verify_key($this->post('key'));
	   if($status) {
		   if($this->post('email')) {
		   $this->email=$this->post('email');
	   }
	   
	   if($this->post('password')) {
		   $this->password= $this->post('password');
	   }
	    $device_id = $this->input->server('HTTP_DEVICE_ID');
	   $info=$this->business_M->login($this->email,$this->password,$device_id);
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
                    'message' => 'Incorrect username or password'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            } 
	   } else {
		    $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect API key'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
	   }
	   }
	   
	   public function detail_post() {
	   $status=$this->business_M->verify_key($this->post('key'));
	   if($status) {
	   $id=$this->post('id');
	   $info=$this->business_M->userById($id);
	   if(!empty($info)) {
	  // $info['phone']= strval($info['phone']);
	   $info1['info']= ($info);
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
	   
	   public function smogDelete_post() {
	   $status=$this->business_M->verify_key($this->post('key'));
	   if($status) {
	   $id=$this->post('smogid');
	   $info=$this->business_M->delSmog($id);
	   if(!empty($info)) {
	  // $info['phone']= strval($info['phone']);
	   $info1['msg']= 'Deleted';
	   $info1['status']=  REST_Controller::HTTP_OK;
	   $this->response($info1, REST_Controller::HTTP_OK);
	   }
	    else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect Smog ID'
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
	   $status=$this->business_M->verify_key($this->post('key'));
	   if($status) {
	   $id=$this->post();
	   $info=$this->business_M->update($id);
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
 public function forgotpass_post() {
		$this->load->library('email');
	   $status=$this->business_M->verify_key($this->post('key'));
	   if($status) {
	   $email=$this->post();
	   $info=$this->business_M->forgot($email);
	   if(!empty($info)) {
		$this->email->from('app@careermarshalletters.com', 'App');
		$this->email->to($email);
		$this->email->subject('Rest Password');
		$this->email->message("Hi, We have reset your password to $info,Please login to change it.");
		 $this->email->send();
	   $info1['msg']= 'Email Sent';
	   $info1['status']=  REST_Controller::HTTP_OK;
	   $this->response($info1, REST_Controller::HTTP_OK);
	   }
	    else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'Invalid Username'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            } 
	   } else {
		    $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect API key'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
	   }
	   }
	   
	    public function getusername_post() {
		$this->load->library('email');
	   $status=$this->business_M->verify_key($this->post('key'));
	   if($status) {
	   $email=$this->post();
	   $info=$this->business_M->get_username($email);
	   if(!empty($info)) {
		$this->email->from('app@careermarshalletters.com', 'App');
		$this->email->to($email);
		$this->email->subject('Your Username');
		$this->email->message("Hi, Your username is $info, Please login now");
		 $this->email->send();
	   $info1['msg']= "Email Sent";
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
	   
	   public function changepass_post() {
	   $status=$this->business_M->verify_key($this->post('key'));
	   if($status) {
	   $info=$this->post();
	   $info=$this->business_M->change($info);
	   if(!empty($info)) {
	   $info1['msg']= 'Changed';
	   $info1['status']=  REST_Controller::HTTP_OK;
	   $this->response($info1, REST_Controller::HTTP_OK);
	   }
	    else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'Invalid email'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            } 
	   } else {
		    $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect API key'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
	   }
	   }
	   
	   public function smogadd_post() {
	   $status=$this->business_M->verify_key($this->post('key'));
	   if($status) {
	   $info=$this->post();
	   $info=$this->business_M->add_smog($info);
	  // print_r($info);
	   if(!empty($info)) {
	 
	   $info1['msg']= 'Added';
	   $info1['status']=  REST_Controller::HTTP_OK;
	   $this->response($info1, REST_Controller::HTTP_OK);
	 
	   }
	    else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'Sorry! Smog certificates already exist'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            } 
	   } else {
		    $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect API key'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
	   }
	   }
	   
	   public function smoglist_post() {
	   $status=$this->business_M->verify_key($this->post('key'));
	   if($status) {
	   $id=$this->post('business_id');
	   $info=$this->business_M->smogList($id);
	  // print_r($info);
	   if(!empty($info)) {
	 
	   $info1['list']= $info;
	   $info1['status']=  REST_Controller::HTTP_OK;
	   $this->response($info1, REST_Controller::HTTP_OK);
	 
	   }
	    else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'Sorry! Smog certificates already exist'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            } 
	   } else {
		    $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect API key'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
	   }
	   }
	   
	   
	   
	   public function signup_post() {
	   $status=$this->business_M->verify_key($this->post('key'));
	   if($status) {
	   $info=$this->post();
	   $info=$this->business_M->add_user($info);
	  // print_r($info);
	   if(!empty($info)) {
	 
	   $info1['msg']= 'Added';
	   $info1['status']=  REST_Controller::HTTP_OK;
	   $this->response($info1, REST_Controller::HTTP_OK);
	 
	   }
	    else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'Sorry! email/username already exist'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            } 
	   } else {
		    $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect API key'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
	   }
	   }
	   
  

}
