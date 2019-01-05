<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function index()
    {
       $data['body']='dashboard';
	   $this->load->view('main',$data);
    }
	
}