<?php
Class Employee_M extends CI_Model {
	private $table_emp='employee_module';
	private $table_address='address_module';
	 public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
		  $this->load->helper('string');

    }
	public function login($email,$password,$device_id) {
		//$query =$this->db->select('employee_id');
		//$query =$this->db->from($this->table_emp);
		//$query =$this->db->where('email', $email);
		//$query = $this->db->or_where('username', $email); 
		//$query =$this->db->where('password', $password);
	    $query = $this->db->select('*')
          ->from($this->table_emp)
          ->where("(email = '$email' OR username = '$email')")
          ->where('password', $password);
		//$query = $this->db->get_where($this->table_emp, array('email' => $email,'password'=>$password));
		//$query = $this->db->get_where_or($this->table_emp, array('username' => $email,'password'=>$password));
		$query = $this->db->get();

		$val = count($query->result());
		$employee = $query->result();
		if($val==1) {
			$data=array(
			'device_id'=>$device_id,
			'user_type'=>'EID',
			'user_id'=>$employee[0]->employee_id
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
		$this->db->join('address_module', 'employee_module.address_id = address_module.id', "LEFT");
		$query = $this->db->get_where($this->table_emp, array("employee_id"=>$id));
		$val = count($query->row());
		if($val==1) {
			return ($query->row());
		} else {
			return false;
		}

	}
	
	public function employee_List($filter,$filter_value) {
		$this->db->select('employee_module.*,garage_module.name');
		//$this->db->from($this->table_emp);
		$query = $this->db->join('address_module', 'employee_module.address_id = address_module.id', "LEFT");
		$this->db->join('garage_module', 'employee_module.garage_id = garage_module.garage_id','Inner');

		//$query = $this->db->get($this->table_emp);
		$query = $this->db->get_where($this->table_emp, array($filter=>$filter_value));
		
			return ($query->result_array());
		

	}
	
	
	public function create($info) {
		if(!$this->mail_exists($info['email']) & !$this->user_exists($info['username'])) {
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
		}
		$this->db->insert('address_module',$add_data);
		$id = $this->db->insert_id();

		if(!empty($info['business_id'])) {
			 $data['business_id']= $info['business_id'];
		}
		if(!empty($info['username'])) {
			$data['username']=$info['username'];
		}
		if(!empty($info['email'])) {
			$data['email']=$info['email'];
		}
		if(!empty($info['phone'])) {
			$data['phone']=$info['phone'];
		}
		if(!empty($info['fname'])) {
			$data['fname']=$info['fname'];
		}
		
		if(!empty($info['lname'])) {
			$data['lname']=$info['lname'];
		}
		if(!empty($info['gender'])) {
			$data['gender']=$info['gender'];
		}
		if(!empty($info['password'])) {
			$data['password']=$info['password'];
		}
		if(!empty($info['garage_id'])) {
			$data['garage_id']=$info['garage_id'];
		}
		if(!empty($info['business_id'])) {
			$data['business_id']=$info['business_id'];
		}
		
			$data['address_id']=$id;
		
		$this->db->insert('employee_module',$data);
		return true;
		}
		else {
			return false;
		}
	
	}
	
	public function forgot($info) {
		if($this->user_exists($info['username'])) {
		$password = random_string('alnum', 8);
		$data['password']=$password;
		$this->db->where('username', $info['username']);
		$this->db->update($this->table_emp, $data);
		return $password;
		}
		else {
			return false;
		}
	}
	
	public function change($info) {
	
		if($this->user_exists($info['username'])) {
		$data['password']=$info['password'];
		$this->db->where('username', $info['username']);
		$this->db->update($this->table_emp, $data);
		return true;
		}
		else {
			return false;
		}
	}
	
	public function get_username($info) {
		//if($this->mail_exists($info['email'])) {
	   $email=$info['email'];
		$query = $this->db->select('username')
          ->from($this->table_emp)
          ->where("(email = '$email' OR phone = '$email')");
		  $query = $this->db->get();
		$val = count($query->result());
		$username = $query->result();
		if($val==1) {
		return $username[0]->username;
		}
		else {
			return false;
		}
	}
	
	public function get_email($info) {
		//if($this->mail_exists($info['email'])) {
	   $username=$info['username'];
		$query = $this->db->select('email')
          ->from($this->table_emp)
          ->where("(username = '$username' OR phone = '$username')");
		  $query = $this->db->get();
		$val = count($query->result());
		$username = $query->result();
		if($val==1) {
		return $username[0]->email;
		}
		else {
			return false;
		}
	}
	
	
	 function mail_exists($key)
{
    $this->db->where('email',$key);
    $query = $this->db->get('employee_module');
    if ($query->num_rows() > 0){
        return true;
    }
    else{
        return false;
    }
}

	function user_exists($key)
	{
    $this->db->where('username',$key);
    $query = $this->db->get('employee_module');
    if ($query->num_rows() > 0){
        return true;
    }
    else{
        return false;
    }
}
	
	public function update($info) {
error_reporting(0);
		$this->db->select('*');
		$query = $this->db->get_where($this->table_emp, array("employee_id"=>$info['id']));
		$aid = ($query->row()->address_id);
		
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
		
		
		$this->db->where('employee_id', $info['id']);
		$this->db->where('business_id', $info['business_id']);
		$this->db->update($this->table_emp, $data);
		
		if(!empty($info['address1'])) {
			 $adata['street_address1']= $info['street_address1'];
		}
		if(!empty($info['address2'])) {
			$adata['street_address2']=$info['street_address1'];
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
		}
	
		$this->db->where('id', $aid);
		if($this->db->update('address_module', $adata)) {
		
		return true;
		} else {
			return false;
		}
	

	}
	
	public function delEmp($bid,$eid) {
		error_reporting(0);

		$this->db->select('address_id');
		$query = $this->db->get_where($this->table_emp, array("employee_id"=>$eid));
		$aid = $query->row()->address_id;
		if($aid) {
		$this->db->where('employee_id', $eid);
		$this->db->where('business_id', $bid);
		if($this->db->delete('employee_module')) {
			$this->db->where('id', $aid);
			$this->db->delete('address_module');
			return true;
		}
		}
		else {
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