<?php
Class Business_M extends CI_Model {
	private $table_emp='business_module';
	private $table_address='address_module';
	 public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
		 $this->load->helper('string');
    }
	public function login($email,$password,$device_id) {
		//$this->db->select('business_id');
		//$query = $this->db->get_where($this->table_emp, array('email' => $email,'password'=>$password));
		  $query = $this->db->select('*')
          ->from($this->table_emp)
          ->where("(email = '$email' OR username = '$email')")
          ->where('password', $password);
		$query = $this->db->get();
		$val = count($query->result());
		$business = $query->result();
		if($val==1) {
			$data=array(
			'device_id'=>$device_id,
			'user_type'=>'BID',
			'user_id'=>$business[0]->business_id
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
		$this->db->join('address_module', 'business_module.address_id = address_module.id', "LEFT");
		$query = $this->db->get_where($this->table_emp, array("business_id"=>$id));
		$val = count($query->row());
		if($val==1) {
			return $query->row();
		} else {
			return false;
		}

	}
	
	public function update($info) {

		$this->db->select('address_id');
		$query = $this->db->get_where($this->table_emp, array("business_id"=>$info['id']));
		$aid = $query->row()->address_id;
		
		if(!empty($info['fname'])) {
			 $data['fname']= $info['fname'];
		}
		if(!empty($info['lname'])) {
			$data['lname']=$info['lname'];
		}
		if(!empty($info['phone'])) {
			$data['phone']=strval($info['phone']);
		}
		if(!empty($info['gender'])) {
			$data['gender']=$info['gender'];
		}
		
		$this->db->where('business_id', $info['id']);
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
			$adata['phone']=strval($info['phone']);
		}
	
		$this->db->where('id', $aid);
		$this->db->update('address_module', $adata);
		
		return true;
	

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
	
	
	function mail_exists($key) {
	$this->db->where('email',$key);
	$query = $this->db->get($this->table_emp);
	if ($query->num_rows() > 0){
	return true;
	}
	else{
	return false;
	}

	}


	public function add_smog($info) {

	/* $this->db->select('address_id');
	$query = $this->db->get_where($this->table, array("invoice_id"=>$info['id']));
	$aid = ($query->row()->address_id); */
	if(!empty($info['business_id'])) {
	 $add_data['business_id']= $info['business_id'];
	}
	if(!empty($info['smog_uid'])) {
	$smog_uid =$info['smog_uid'];
	}
	if(!empty($info['from'])) {
	$from=$info['from'];
	}
	
	if(!empty($info['to'])) {
	$to = $info['to'];
	}
	$smog=array();
	 for($i=$from; $i<=$to;$i++) {
		$smog[]=$smog_uid.'_'.$i; 
		$add_data['smog_id']=$smog_uid.'_'.$i; 
		$sql = $this->db->select('smog_id')
          ->from("smog_details")
		  ->where('smog_id',$add_data['smog_id']);
		   $query = $this->db->get();
		//$query = $this->db->query($sql);
		//print_r($query->num_rows());
		if ($query->num_rows() == 0) {
		  // no duplicates found, add new record
		  $this->db->insert('smog_details',$add_data);
		}
		else {
			/* $sql = $this->db->select('smog_id')
          ->from("smog_details");
		
		   $query = $this->db->get();
			return $query->result(); */
			return false;
		}
		
		
		
		
		/* if(!$this->db->insert('smog_details',$add_data)) {
			$query = $this->db->select('*')
          ->from("smog_details");
         
		  $query = $this->db->get();
		
		return $query->result();
		} */
	 }
	//print_r($smog);
	
	//$this->db->insert('smog_details',$add_data);

	return true;

	}
	
	 public function smogList($id) {
	   error_reporting(0);
		$this->db->select('*');
		$query = $this->db->get_where('smog_details', array("business_id"=>$id));
		
		$val = count($query->result());
		if($val>=1) {
			return $query->result();
		} else {
			return false;
		}
		
		
		
	}
	
	
   public function delSmog($id) {
	   error_reporting(0);
		$this->db->select('id');
		$query = $this->db->get_where('smog_details', array("id"=>$id));
		$aid = $query->row()->id;
		if(!empty($aid)) {
		$this->db->where('id', $id);
		if($this->db->delete('smog_details')) {
			return true;
		} 
		} else {
			return false;
		}
		
	}
	
	
	
	
	
	
	public function add_user($info) {

	/* $this->db->select('address_id');
	$query = $this->db->get_where($this->table, array("invoice_id"=>$info['id']));
	$aid = ($query->row()->address_id); */
	if(!empty($info['fname'])) {
	 $add_data['fname']= $info['fname'];
	}
	if(!empty($info['lname'])) {
	 $add_data['lname']= $info['lname'];
	}
	if(!empty($info['username'])) {
	 $add_data['username']= $info['username'];
	}
	if(!empty($info['email'])) {
	 $add_data['email']= $info['email'];
	}
	if(!empty($info['password'])) {
	 $add_data['password']= $info['password'];
	}

		$sql = $this->db->select('*')
          ->from("business_module")
		  ->where('email',$add_data['email'])
		  ->or_where('username',$add_data['username']);
		   $query = $this->db->get();
		//$query = $this->db->query($sql);
		//print_r($query->num_rows());
		if ($query->num_rows() == 0) {
		  // no duplicates found, add new record
		  $this->db->insert('business_module',$add_data);
		}
		else {
			/* $sql = $this->db->select('smog_id')
          ->from("smog_details");
		
		   $query = $this->db->get();
			return $query->result(); */
			return false;
		}


	return true;

	}
	
	
	

function user_exists($key) {
    $this->db->where('username',$key);
    $query = $this->db->get($this->table_emp);
    if ($query->num_rows() > 0){
        return true;
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