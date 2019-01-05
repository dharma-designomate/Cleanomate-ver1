<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Garages extends CI_Controller {

    public function index()
    {
       $data['body']='garages_list';
	   $this->load->view('main',$data);
    }
	
	public function listing()
    {
		
		$data = array(
            'business_id'  => $this->session->userdata('logged_in')['id'],
            'key'    => 't1E1a6p3j2'
    );

    $data_string = json_encode($data);

    $url = 'http://careermarshalletters.com/app/api/garage/garagelist';

    $header_data= array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string)
    );
	
	$result=json_decode($this->request($data,$url,$header_data));
	
	    $data['listing'] = $result;
       $data['body']='garages_list';
	   $this->load->view('main',$data);
    }
	
	public function view($id)
    {
		
		$data = array(
            'garage_id'  => $id,
            'key'    => 't1E1a6p3j2'
    );

    $data_string = json_encode($data);

    $url = 'http://careermarshalletters.com/app/api/garage/viewgarage';

    $header_data= array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string)
    );
	
	$result=json_decode($this->request($data,$url,$header_data));
	
	   $data['garage_info'] = $result;
       $data['body']='garage_edit';
	   $this->load->view('main',$data);
    }
	
	public function addnew()
    {
	
       $data['body']='new_garage';
	   $this->load->view('main',$data);
    }
	
	public function add()
    {
		
	$data = array(
		'key'    => 't1E1a6p3j2',
		'business_id' =>$this->session->userdata('logged_in')['id'],
		'email' => $this->input->post('email'),
		'phone' =>$this->input->post('phone'),
		'name' =>$this->input->post('garage_name'),
		'registration_no' =>$this->input->post('registration_no'),
		'logo' =>$this->input->post('logo'),
		'street_address1' =>$this->input->post('street_address1'),
		'street_address2' =>$this->input->post('street_address2'),
		'city' =>$this->input->post('city'),
		'state' =>$this->input->post('state'),
		'zipcode' =>$this->input->post('zipcode'),
);

    $data_string = json_encode($data);

    $url = 'http://careermarshalletters.com/app/api/garage/creategarage';

    $header_data= array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string)
    );
	
	$result=json_decode($this->request($data,$url,$header_data));
	$this->session->set_flashdata('message', 'Garage added succefully!');
	redirect("garages/addnew");

    }
	
	public function update()
    {
		
	$data = array(
		'garage_id'  => $this->input->post('id'),
		'key'    => 't1E1a6p3j2',
		'email' => $this->input->post('email'),
		'phone' =>$this->input->post('phone'),
		'name' =>$this->input->post('garage_name'),
		'registration_no' =>$this->input->post('registration_no'),
		'logo' =>$this->input->post('logo'),
		'street_address1' =>$this->input->post('street_address1'),
		'street_address2' =>$this->input->post('street_address2'),
		'city' =>$this->input->post('city'),
		'state' =>$this->input->post('state'),
		'zipcode' =>$this->input->post('zipcode'),
);

    $data_string = json_encode($data);

    $url = 'http://careermarshalletters.com/app/api/garage/editgarage';

    $header_data= array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string)
    );
	
	$result=json_decode($this->request($data,$url,$header_data));
	redirect('garages/view/'.$this->input->post('id'));
	   
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