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
class Employee extends REST_Controller {

    function __construct()
    { 
        // Construct the parent class
        parent::__construct();
        $this->load->model('employee_M');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_post']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

	public function login_post() {
	   $status=$this->employee_M->verify_key($this->post('key'));
	   if($status) {
		   if($this->post('email')) {
		   $this->email=$this->post('email');
	   }
	   
	   if($this->post('password')) {
		   $this->password= $this->post('password');
	   }
	     $device_id = $this->input->server('HTTP_DEVICE_ID');
	   $info=$this->employee_M->login($this->email,$this->password,$device_id);
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
	   
	    public function createEmployee_post() {
	   $status=$this->employee_M->verify_key($this->post('key'));
	   if($status) {
	   $info=$this->post();
	   $info=$this->employee_M->create($info);
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
                    'message' => 'Email/Username already exists'
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
	   $status=$this->employee_M->verify_key($this->post('key'));
	   if($status) {
	   $id=$this->post('id');
	   $info=$this->employee_M->userById($id);
	   if(!empty($info)) {
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
	   
	   public function employee_delete_post() {
	   $status=$this->employee_M->verify_key($this->post('key'));
	   if($status) {
	   $bid=$this->post('business_id');
	   $eid=$this->post('employee_id');
	   $info=$this->employee_M->delEmp($bid,$eid);
	   if(!empty($info)) {
	   $info1['info']= ($info);
	   $info1['status']=  REST_Controller::HTTP_OK;
	   $this->response($info1, REST_Controller::HTTP_OK);
	   }
	    else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect Employee ID/Business ID'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            } 
	   } else {
		    $this->response([
                    'status' => FALSE,
                    'message' => 'Incorrect API key'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
	   }
	   }
	   
	   
	    public function employeeList_post() { 
	   $status=$this->employee_M->verify_key($this->post('key'));
	   if($status) {
	   $filter=$this->post('filter');
	   $filter_value=$this->post('filter_value');
	   $info=$this->employee_M->employee_List('employee_module.'.$filter, $filter_value);
	   if(!empty($info)) {
	   $info1['info']= ($info);
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
	   
	   
	   
	   
	   public function update_post() {
	   $status=$this->employee_M->verify_key($this->post('key'));
	   if($status) {
	   $id=$this->post();
	   $info=$this->employee_M->update($id);
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
	   $status=$this->employee_M->verify_key($this->post('key'));
	   if($status) {
	   $email=$this->post();
	    
	   $info=$this->employee_M->forgot($email);
	   $email=$this->employee_M->get_email($email);
	   if(!empty($info)) {
		$this->email->from('app@careermarshalletters.com', 'App');
		$this->email->to($email);
		$this->email->subject('Reset Password');
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
	   
	    public function getusername_post() {
		$this->load->library('email');
	   $status=$this->employee_M->verify_key($this->post('key'));
	   if($status) {
	   $email=$this->post();
	   $info=$this->employee_M->get_username($email);
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
                    'message' => 'Incorrect '
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
	   $status=$this->employee_M->verify_key($this->post('key'));
	   if($status) {
	   $info=$this->post();
	   $info=$this->employee_M->change($info);
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
	   
	  

   /*public function info_post()
    {
        // Users from a data store e.g. database
        $info = [
            ['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'fact' => 'Loves coding'],
            ['id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'],
            ['id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', ['hobbies' => ['guitar', 'cycling']]],
        ];

        $id = $this->post('id');

        // If the id parameter doesn't exist return all the info

        if ($id === NULL)
        {
            // Check if the info data store contains info (in case the database result returns NULL)
            if ($info)
            {
                // Set the response and exit
                $this->response($info, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No info were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.

        $id = (int) $id;

        // Validate the id.
        if ($id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Get the user from the array, using the id as key for retreival.
        // Usually a model is to be used for this.

        $user = NULL;

        if (!empty($info))
        {
            foreach ($info as $key => $value)
            {
                if (isset($value['id']) && $value['id'] === $id)
                {
                    $user = $value;
                }
            }
        }

        if (!empty($user))
        {
            $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function info_post()
    {
        // $this->some_model->update_user( ... );
        $message = [
            'id' => 100, // Automatically generated by the model
            'name' => $this->post('name'),
            'email' => $this->post('email'),
            'message' => 'Added a resource'
        ];
	   $username=$password=$name=$email=$phone=$address_line_1=$address_line_2=$city=$state=$country=$zipcode=$shopname='';
	   if(!empty($this->post('username'))) { $username=$this->post('username');}
	   if(!empty($this->post('password'))) { $password=$this->post('password');}
		if(!empty($this->post('name'))) { $name=$this->post('name');}
		if(!empty($this->post('email'))) { $email=$this->post('email');}
		if(!empty($this->post('phone'))) { $phone=$this->post('phone');}
		if(!empty($this->post('address_line_1'))) { $address_line_1=$this->post('address_line_1');}
		if(!empty($this->post('address_line_2'))) { $address_line_2=$this->post('address_line_2');}
		if(!empty($this->post('city'))) { $city=$this->post('city');}
		if(!empty($this->post('state'))) { $state=$this->post('state');}
		if(!empty($this->post('country'))) { $country=$this->post('country');}
		if(!empty($this->post('zipcode'))) { $zipcode=$this->post('zipcode');}
		if(!empty($this->post('shopname'))) { $shopname=$this->post('shopname');}
		$data = array(
		'username' => $username,
        'password' => $password,
        'name' => $name,
        'email' => $email,
		'phone' =>$phone,
		'address_line_1' =>$address_line_1,
		'address_line_2' => $address_line_2,
		'city' => $city,
		'state' =>$state,
		'country' => $country,
		'zipcode' => $zipcode,
		'shop_name' => $shopname
);
$this->db->insert('app_employer', $data);

      $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function info_delete()
    {
        $id = (int) $this->post('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // $this->some_model->delete_something($id);
        $message = [
            'id' => $id,
            'message' => 'Deleted the resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    } */

}
