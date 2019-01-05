<?php
Class Customer_M extends CI_Model {
	private $table_emp='customer_module';
	private $table_address='address_module';
	 public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }
	public function login($email,$phone,$device_id) {
		$this->db->select('*');
		$query = $this->db->get_where($this->table_emp, array('email' => $email,'phone'=>$phone));
		$val = count($query->row());
		if($val==1) {
			$data=array(
			'device_id'=>$device_id,
			'user_type'=>'CID',
			'user_id'=>$query->row()->customer_id
			);
			$this->db->insert('login_status',$data);
			
			return $query->row();
		} else {
			return false;
		}

	}
	public function userById($id) {
		$this->db->select('*');
		//$this->db->from($this->table);
		$this->db->join('address_module', 'customer_module.address_id = address_module.id', "LEFT");
		$query = $this->db->get_where($this->table_emp, array("customer_id"=>$id));
		$val = count($query->row());
		if($val==1) {
			return $query->row();
		} else {
			return false;
		}

	}
	public function update($info) {

		$this->db->select('address_id');
		$query = $this->db->get_where($this->table_emp, array("customer_id"=>$info['id']));
		$aid = $query->row()->address_id;
		
		if(!empty($info['fname'])) {
			 $data['fname']= $info['fname'];
		}
		if(!empty($info['lname'])) {
			$data['lname']=$info['lname'];
		}
		if(!empty($info['phone'])) {
			$data['phone']=$info['phone'];
		}
		
		
		if(!empty($info['gender'])) {
			$data['gender']=$info['gender'];
		}
		
		$this->db->where('customer_id', $info['id']);
		$this->db->update($this->table_emp, $data);
		
		if(!empty($info['street_address1'])) {
			 $adata['street_address1']= $info['street_address1'];
		}
		if(!empty($info['street_address2'])) {
			$adata['street_address2']=$info['street_address2'];
		}
		if(!empty($info['city'])) {
			$adata['city']=$info['city'];
		}
		if(!empty($info['state'])) {
			$adata['state']=$info['state'];
		}
		if(!empty($info['zipcode'])) {
			$adata['zipcode']=$info['zipcode'];
		}
		
		if(!empty($info['phone'])) {
			$adata['phone']=$info['phone'];
		}else {
		$adata['phone']="";
		}
	
		$this->db->where('id', $aid);
		$this->db->update('address_module', $adata);
		
		return true;
	

	}
	
	public function create($info) {
	//print_r($info);
			
		/* $this->db->select('address_id');
		$query = $this->db->get_where($this->table, array("invoice_id"=>$info['id']));
		$aid = ($query->row()->address_id); */
		if($this->user_exists($info['email'],$info['phone'])) {
			$customer_id = $this->user_exists($info['email'],$info['phone']);
		} else {
		if(!empty($info['street_address1'])) {
			 $add_data['street_address1']= $info['street_address1'];
		}
		if(!empty($info['street_address2'])) {
			$add_data['street_address2']=$info['street_address2'];
		}
		if(!empty($info['city'])) {
			$add_data['city']=$info['city'];
		}
		if(!empty($info['state'])) {
			$add_data['state']=$info['state'];
		}
		if(!empty($info['zipcode'])) {
			$add_data['zipcode']=$info['zipcode'];
		}
		if(!empty($info['phone'])) {
			$add_data['phone']=$info['phone'];
		} else{
			$add_data['phone']="";
		}
		$this->db->insert('address_module',$add_data);
		$id = $this->db->insert_id();
		
				
		if(!empty($info['fname'])) {
			 $data['fname']= $info['fname'];
		}
		if(!empty($info['lname'])) {
			$data['lname']=$info['lname'];
		}
		if(!empty($info['dl'])) {
			$data['dl']=$info['dl'];
		}
		if(!empty($info['email'])) {
			$data['email']=$info['email'];
		}
		if(!empty($info['phone'])) {
			$data['phone']=$info['phone'];
		}
		if(!empty($info['gender'])) {
			$data['gender']=$info['gender'];
		}
		if(!empty($id)) {
			$data['address_id']=$id;
		}
		if(!empty($info['password'])) {
			$data['password']=$info['password'];
		}
		
		$this->db->insert($this->table_emp,$data);
		$customer_id = $this->db->insert_id();
		}
		
		return $customer_id;

	}
	
	function viewLicense($license) {
		$this->db->select('*');
		//$this->db->from($this->table);
		$this->db->join('address_module', 'customer_module.address_id = address_module.id', "LEFT");
		$query = $this->db->get_where($this->table_emp, array("dl"=>$license));
		$val = count($query->row());
		if($val==1) {
			return $query->row();
		} else {
			return false;
		}
	}
	
	function user_exists($email,$phone) {
    $this->db->where('email',$email);
	$this->db->or_where('phone',$phone);
    $query = $this->db->get($this->table_emp);
    if ($query->num_rows() > 0){
        return ($query->row('customer_id'));
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