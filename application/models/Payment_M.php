<?php
Class Payment_M extends CI_Model {
	private $table='payment_module';
	 public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
		$this->load->helper('date');

    }

	
	public function addInfo($info) {
			
		/* $this->db->select('address_id');
		$query = $this->db->get_where($this->table, array("invoice_id"=>$info['id']));
		$aid = ($query->row()->address_id); */
	
		if(!empty($info['payment_id'])) {
			 $data['payment_id']= $info['payment_id'];
		} else {
			$data['payment_id']="";
		}
		if(!empty($info['reference_id'])) {
			$data['reference_id']=$info['reference_id'];
		}
		if(!empty($info['status'])) {
			$data['status']=$info['status'];
		}
		if(!empty($info['success_url'])) {
			$data['success_url']=$info['success_url'];
		}
		
		$this->db->insert($this->table,$data);
		$transcation_id = $this->db->insert_id();
	
		return $transcation_id;

	}
	
	
}