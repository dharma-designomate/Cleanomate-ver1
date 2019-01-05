<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {

    public function index()
    {
        $this->load->helper('url');

        $this->load->view('signup');
    }
	
	
	public function business() {
		 $data = array(
		   'fname'      => $this->input->post('fname'),
		   'lname'      => $this->input->post('lname'),
		    'username'      => $this->input->post('username'),
            'email'      => $this->input->post('email'),
            'password' => $this->input->post('password'),
            'key'    => 't1E1a6p3j2'
    );

    $data_string = json_encode($data);

    $url = 'http://careermarshalletters.com/app/api/business/signup';

    $header_data= array(
    'Content-Type: application/json',
	'device_id: 1234',
    'Content-Length: ' . strlen($data_string)
    );

	$result=$this->request($data,$url,$header_data);

    $login = json_decode($result);
	if($login->status==false) {
		$this->session->set_flashdata('message_name', 'Sorry ! Email/Username Already Exists');

		redirect('signup');

		//$data['body']='dashboard';
		//$this->load->view('main',$data);
	} 
	else {
		$this->session->set_flashdata('message_name', 'Registered Successfully');

	redirect('signup');
	}
	}
	
	
	
	public function login_success($id) {
		$data = array(
            'id'      => $id,
            'key'    => 't1E1a6p3j2'
    );

    $data_string = json_encode($data);

    $url = 'http://careermarshalletters.com/app/api/business/detail';

    $header_data= array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string)
    );
	
	$result=json_decode($this->request($data,$url,$header_data));
	
	$sess_array = array(
	'id'=>$result->info->business_id,
	'email' => $result->info->email,
	'fname' =>$result->info->fname,
	'lname' =>$result->info->lname,
	);
// Add user data in session
	$this->session->set_userdata('logged_in', $sess_array);
	}
	
	public function request($data,$url,$header_data) {
		 
    $data_string = json_encode($data);

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");

    curl_setopt($curl, CURLOPT_HTTPHEADER, $header_data);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);  // Insert the data

    // Send the request
    $result = curl_exec($curl);

    // Free up the resources $curl is using
    curl_close($curl);
	return $result;
	}
}
