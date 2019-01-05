<?php
Class Car_M extends CI_Model {
	private $table='car_module';
	 public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
		$this->load->helper('date');

    }

	
	public function addInfo($info) {
			
		/* $this->db->select('address_id');
		$query = $this->db->get_where($this->table, array("invoice_id"=>$info['id']));
		$aid = ($query->row()->address_id); 
		if($this->car_exists($info['car_number'])) {
			$car_id = $this->car_exists($info['car_number']);
		} else {
			if(!empty($info['car_number'])) {
			 $data['car_number']= $info['car_number'];
		}*/
		
		if(!empty($info['car_number'])) {
			 $data['car_number']= $info['car_number'];
		}
		if(!empty($info['model'])) {
			 $data['model']= $info['model'];
		}
	
		if(!empty($info['year'])) {
			$data['year']=$info['year'];
		}
		if(!empty($info['customer_id'])) {
			$data['customer_id']=$info['customer_id'];
		}
		if(!empty($info['car_state'])) {
			$data['car_state']=$info['car_state'];
		}
		if(!empty($info['car_make'])) {
			$data['car_make']=$info['car_make'];
		}
		if(!empty($info['license_number'])) {
			$data['license_number']=$info['license_number'];
		}
		if(!empty($info['tire_pressure_check'])) {
			$data['tire_pressure_check']=$info['tire_pressure_check'];
		}
		
		
		
		$this->db->insert($this->table,$data);
		$car_id = $this->db->insert_id();
		
		return $car_id;

	}
	function viewCar($car_number) {
	$this->db->select('*');
	$this->db->join('customer_module', 'car_module.customer_id = customer_module.customer_id', "LEFT");
	$this->db->join('invoice_module', 'car_module.car_id = invoice_module.car_id', "LEFT");
	$query = $this->db->get_where($this->table, array("car_number"=>$car_number));
    if ($query->num_rows() > 0){
        return ($query->row());
    }
    else{
        return false;
    }
	}
	
	function car_exists($key) {
    $this->db->where('car_number',$key);
    $query = $this->db->get($this->table);
    if ($query->num_rows() > 0){
        return ($query->row('car_id'));
    }
    else{
        return false;
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