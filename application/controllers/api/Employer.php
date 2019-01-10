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
class Employer extends REST_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('employer_M');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_post']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

	public function garageList_post() {
	   $status=$this->garage_M->verify_key($this->post('key'));
	   if($status) {
		   if($this->post('business_id')) {
		   $this->business_id=$this->post('business_id');
	   }
	  
	   $info=$this->garage_M->garageList($this->business_id);
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
                    'message' => 'Incorrect Business ID'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            } 
	   } else {
		    $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect API key'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
	   }
	   }
	   public function viewEmp_post() {
	   $status=$this->employer_M->verify_key($this->post('key'));
	   if($status) {
		   if($this->post('emp_id')) {
		   $this->emp_id=$this->post('emp_id');
	   }
	  
	   $info=$this->employer_M->viewEmp($this->emp_id);
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
                    'message' => 'Incorrect Emp ID'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            } 
	   } else {
		    $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect API key'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
	   }
	   }
	   
	   public function deleteGarage_post() {
	   $status=$this->garage_M->verify_key($this->post('key'));
	   if($status) {
		   if($this->post('garage_id')) {
		   $this->garage_id=$this->post('garage_id');
	   }
	  
	   $info=$this->garage_M->delGarage($this->garage_id);
	   if(!empty($info)) {
	   $info1['info']= "deleted";
	   $info1['status']=  REST_Controller::HTTP_OK;
	   $this->response($info1, REST_Controller::HTTP_OK);
	   }
	    else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect Garage ID'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            } 
	   } else {
		    $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect API key'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
	   }
	   }
	   
	  
	public function login_post() {
	   $status=$this->employer_M->verify_key($this->post('key'));
	   if($status) {
		   if($this->post('username')) {
		   $this->email=$this->post('username');
	   }
	   
	   if($this->post('password')) {
		   $this->password= $this->post('password');
	   }
	    //$device_id = $this->input->server('HTTP_DEVICE_ID');
	   $info=$this->employer_M->login($this->email,$this->password);
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
	   
	   public function createmployer_post() { 
	   $status=$this->employer_M->verify_key($this->post('key'));
	   if($status) {
	   $info=$this->post();
	   $info=$this->employer_M->addInfo($info);
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
	   
	   
	   public function addBooking_post() { 
	   $status=$this->employer_M->verify_key($this->post('key'));
	   if($status) {
	   $info=$this->post();
	   $info=$this->employer_M->addBookingInfo($info);
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
	   
	   public function addMaidReview_post() { 
	   $status=$this->employer_M->verify_key($this->post('key'));
	   if($status) {
	   $info=$this->post();
	   $info=$this->employer_M->addMaidReview($info);
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
	   
	   
	   
	    public function editEmp_post() {
	   $status=$this->employer_M->verify_key($this->post('key'));
	   if($status) {
	   $id=$this->post();
	   $info=$this->employer_M->updateEmp($id);
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
	   
	   public function maidHistory_post() {
	   $status=$this->employer_M->verify_key($this->post('key'));
	   if($status) {
	   $id=$this->post('emp_id');
	   $info=$this->employer_M->maidHistory($id);
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
	   
	   
	   public function employerHelp_post() {
	   $status=$this->employer_M->verify_key($this->post('key'));
	   if($status) {
	   $id=$this->post();
	   $info=$this->employer_M->maidHelp($id);
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
                    'message' => 'Something went wrong'
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
