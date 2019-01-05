<?php
Class Services_M extends CI_Model {
	private $table_emp='customer_services';
	private $table_address='address_module';
	 public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }
	public function servicesList($id) {
		$this->db->select('*');
		//$this->db->from($this->table);
		//if($id!='') {
		$query = $this->db->get_where($this->table_emp, array("business_id"=>$id));
		//} else {
		//	$query = $this->db->get($this->table_emp);
		//}
		$val = count($query->result());
		if($val>=1) {
			return $query->result();
		} else {
			return false;
		}

	}
	
	public function viewService($id) {
		$this->db->select('*');
		//$this->db->from($this->table);
		$query = $this->db->get_where($this->table_emp, array("id"=>$id));
		$val = count($query->row());
		if($val>=1) {
			return $query->result();
		} else {
			return false;
		}

	}
	
	public function delService($id) {
		$this->db->select('id');
		$this->db->where('id', $id);
		if($this->db->delete($this->table_emp)) {
		
			return true;
		} else {
			return false;
		}
		
	}
	
	public function addInfo($info) {
			
		/* $this->db->select('address_id');
		$query = $this->db->get_where($this->table, array("invoice_id"=>$info['id']));
		$aid = ($query->row()->address_id); */
		if(!empty($info['service_name'])) {
			 $data['service_name']= $info['service_name'];
		}
		if(!empty($info['price'])) {
			$data['price']=$info['price'];
		}
		
		if(!empty($info['qty'])) {
			$data['qty']=$info['qty'];
		}
		
		if(!empty($info['business_id'])) {
			 $data['business_id']= $info['business_id'];
		}
		
		
		$this->db->insert($this->table_emp,$data);
		
		return true;

	}
	

	
	public function editService($info) {
		
		if(!empty($info['service_name'])) {
			$data['service_name']=$info['service_name'];
		}
		if(!empty($info['price'])) {
			$data['price']=$info['price'];
		}
		if(!empty($info['qty'])) {
			$data['qty']=$info['qty'];
		}
		
		$this->db->where('id', $info['service_id']);
		$this->db->update($this->table_emp, $data);
		
		return true;

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