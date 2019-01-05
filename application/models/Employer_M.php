<?php
Class Employer_M extends CI_Model {
	
	private $table_emp='employer_details';

	 public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }
	public function garageList($id) {
		$this->db->select('*');
		//$this->db->from($this->table);
		$this->db->order_by("garage_id","desc");
		$this->db->join('address_module', 'garage_module.address_id = address_module.id', "LEFT");
		$query = $this->db->get_where($this->table_emp, array("business_id"=>$id));
		
		$val = count($query->result());
		if($val>=1) {
			return $query->result();
		} else {
			return false;
		}

	}
	
	public function viewEmp($id) {
		$this->db->select('*');
		//$this->db->from($this->table);
		//$this->db->join('address_module', 'garage_module.address_id = address_module.id', "LEFT");
		$query = $this->db->get_where($this->table_emp, array("id"=>$id));
		$val = count($query->row());
		if($val>=1) {
			return $query->result();
		} else {
			return false;
		}

	}
	
	public function maidHistory($id) {
		$this->db->select('*');
		//$this->db->from($this->table);
		$this->db->join('maid_details', 'maid_details.id = attendance_details.maid_id', "LEFT");
		$query = $this->db->get_where('attendance_details', array("attendance_details.emp_id"=>$id));
		$val = count($query->row());
		if($val>=1) {
			return $query->result();
		} else {
			return false;
		}

	}
	
	public function delGarage($id) {
		$this->db->select('address_id');
		$query = $this->db->get_where($this->table_emp, array("garage_id"=>$id));
		$aid = $query->row()->address_id;
		$this->db->where('garage_id', $id);
		if($this->db->delete('garage_module')) {
			$this->db->where('id', $aid);
			$this->db->delete('address_module');
			return true;
		} else {
			return false;
		}
		
	}
	
	 public function login($email,$password) {
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
			//'device_id'=>$device_id,
			//'user_type'=>'EID',
			'user_id'=>$employee[0]->id
			);
			//$this->db->insert('login_status',$data);
			return $query->row();
		} else {
			return false;
		}

	}
	public function addInfo($info) {
			
		/* $this->db->select('address_id');
		$query = $this->db->get_where($this->table, array("invoice_id"=>$info['id']));
		$aid = ($query->row()->address_id); */
		if(!$this->mail_exists($info['email']) & !$this->user_exists($info['username'])) {
	if(!empty($info['username'])) {
			 $add_data['username']= $info['username'];
		}
		if(!empty($info['password'])) {
			 $add_data['password']= $info['password'];
		}
	if(!empty($info['first_name'])) {
			 $add_data['first_name']= $info['first_name'];
		}
		if(!empty($info['last_name'])) {
			$add_data['last_name']=$info['last_name'];
		}
		if(!empty($info['phone'])) {
			$add_data['phone']=$info['phone'];
		}
		
		if(!empty($info['address'])) {
			$add_data['address']=$info['address'];
		}
		
		if(!empty($info['mothers_name'])) {
			$add_data['mothers_name']=$info['mothers_name'];
		}
		if(!empty($info['fathers_husband_name'])) {
			$add_data['fathers_husband_name']=$info['fathers_husband_name'];
		}
		if(!empty($info['email'])) {
			$add_data['email']=$info['email'];
		}
		if(!empty($info['time_slot'])) {
			$add_data['time_slot']=$info['time_slot'];
		}
		if(!empty($info['photo'])) {
			$add_data['photo']=$this->docupload($info['photo']);
		}
		$this->db->insert('employer_details',$add_data);
		$id = $this->db->insert_id();

		
		
		return true;
		}
		else {
			return false;
		}

	}
	
	
	public function addBookingInfo($info) {
			
	
	
	if(!empty($info['employer_id'])) {
			 $add_data['employer_id']= $info['employer_id'];
		}
		if(!empty($info['maid_id'])) {
			 $add_data['maid_id']= $info['maid_id'];
		}
	if(!empty($info['apartment'])) {
			 $add_data['apartment']= $info['apartment'];
		}
		if(!empty($info['flat_num'])) {
			$add_data['flat_num']=$info['flat_num'];
		}
		if(!empty($info['time_slot'])) {
			$add_data['time_slot']=$info['time_slot'];
		}
		
		if(!empty($info['flat_type'])) {
			$add_data['flat_type']=$info['flat_type'];
		}
		
		
		$this->db->insert('booking_requests',$add_data);
		$id = $this->db->insert_id();

		
		return true;
		
	}
	
	
	public function addMaidReview($info) {
	
	if(!empty($info['employer_id'])) {
			 $add_data['employer_id']= $info['employer_id'];
		}
		if(!empty($info['maid_id'])) {
			 $add_data['maid_id']= $info['maid_id'];
		}
	if(!empty($info['review'])) {
			 $add_data['review']= $info['review'];
		}
		if(!empty($info['rating'])) {
			$add_data['rating']=$info['rating'];
		}
		
		$this->db->insert('maid_reviews',$add_data);
		$id = $this->db->insert_id();

		
		return true;
		
	}
	
	
	
	public function updateEmp($info) {
			
		/* $this->db->select('address_id');
		$query = $this->db->get_where($this->table, array("invoice_id"=>$info['id']));
		$aid = ($query->row()->address_id); */
		//if(!$this->mail_exists($info['email']) & !$this->user_exists($info['username'])) {
	
	if(!empty($info['first_name'])) {
			 $add_data['first_name']= $info['first_name'];
		}
		if(!empty($info['last_name'])) {
			$add_data['last_name']=$info['last_name'];
		}
		if(!empty($info['phone'])) {
			$add_data['phone']=$info['phone'];
		}
		
		if(!empty($info['address'])) {
			$add_data['address']=$info['address'];
		}
		
		if(!empty($info['mothers_name'])) {
			$add_data['mothers_name']=$info['mothers_name'];
		}
		if(!empty($info['fathers_husband_name'])) {
			$add_data['fathers_husband_name']=$info['fathers_husband_name'];
		}
		
		if(!empty($info['time_slot'])) {
			$add_data['time_slot']=$info['time_slot'];
		}
		if(!empty($info['photo'])) {
			$add_data['photo']=$this->docupload($info['photo']);
		}
		
		if(!empty($info['photo'])) {
			$add_data['photo']=$this->docupload($info['photo']);
		 }
		
		//$this->db->insert('employer_details',$add_data);
		//$id = $this->db->insert_id();

		$this->db->where('id',$info['id']);
		$this->db->update('employer_details',$add_data);
		
		return true;
		

	}
	
	public function doupload($imagespic)
     {
		 
	
       $upPath=FCPATH.'assets/userdoc/images/'; 
	   if(isset($imagespic)) {
		   
		define('UPLOAD_DIR', $upPath);
		$img = $imagespic;
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$imagename = uniqid() . '.png';
		$file = UPLOAD_DIR .$imagename;
		$success = file_put_contents($file, $data);
		//print $success ? $file : 'Unable to save the file.';   
		if($success) {
			return $imagename;
		} else {
			return 'no-image.png';
		}
		   
   /*
      $new_name = time().$_FILES["logo"]['name'];
		
        $config = array(
        'upload_path' => $upPath,
        'allowed_types' => "gif|jpg|png|jpeg",
        'overwrite' => TRUE,
        'max_size' => "2048000", 
        'max_height' => "768",
        'max_width' => "1024"
        );
		$config['file_name'] = $new_name;
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('logo'))
        { 
            $data['imageError'] =  $this->upload->display_errors();
			return false;
        }
        else
        {
            $imageDetailArray = $this->upload->data();
             $image =  $imageDetailArray['file_name'];
		
			return $image;
        }
		} else {
		return 'no-image.png';
		}
	 */}
     }
	
	function docupload($info) {
		
		$images=$info;
		//$upPath=APPPATH.'../assets/userdocs/images/'; 
		//define('UPLOAD_DIR', $upPath);
			$userinfo['userdocs'] = $info;
			$msg=$this->docsave($userinfo);
		return $msg;
		
	}
	
	
	
	function docsave($info)
     {
	   if(isset($info["userdocs"])) {
		 
		$img = $info["userdocs"];
		$ext=$this->retrieveExtension($img);
		if($ext=='image/jpg'|| $ext=='image/jpeg') {
		 $img = str_replace('data:image/jpeg;base64,', '', $img);
		 $img = str_replace(' ', '+', $img);
		 $data = base64_decode($img);
		$imagename = uniqid() . '.jpg';
		$file = UPLOAD_DIR .$imagename;
		$success = file_put_contents($file, $data);
		//print $success ? $file : 'Unable to save the file.';   
		if($success) {
			return $imagename;
			/*$data=array(
			'invoice_id'=>$info["invoice_id"],
			'documents'=>$imagename
			);
			$this->db->insert('documents',$data);
			$msg["success"]=$info['name']." Saved";
			*/
			
		} else {
			
			return 'no-image.png';
			//$msg["error"]=$info['name']." Failed";
			
		}
		} elseif($ext=='image/png') {
		$img = str_replace('data:image/png;base64,', '', $img);
		//$img = str_replace('data:image//jpeg;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$imagename = uniqid() . '.png';
		
		$file = UPLOAD_DIR .$imagename;
		$success = file_put_contents($file, $data);
		//print $success ? $file : 'Unable to save the file.';   
		if($success) {
			return $imagename;
			/*$data=array(
			'invoice_id'=>$info["invoice_id"],
			'documents'=>$imagename
			);
			$this->db->insert('documents',$data);
			$msg["success"]=$info['name']." Saved"; */
			
		} else {
			return 'no-image.png';
			//$msg["error"]=$info['name']." Failed";
			
		}
		}
		else {
			return 'no-image.png';
			
			
		}
	 // return $msg;
	   }
	 }
	
	function retrieveExtension($data){
 
	$pos  = strpos($data, ';');
	$type = explode(':', substr($data, 0, $pos))[1];

	return $type;

	}
	
	
	public function editGarage($info) {
			
		$this->db->select('address_id');
		$query = $this->db->get_where($this->table_emp, array("garage_id"=>$info['garage_id']));
		$aid = $query->row()->address_id;
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
		$this->db->where('id', $aid);
		$this->db->update($this->table_address, $add_data);


		if(!empty($info['email'])) {
			$data['email']=$info['email'];
		}
		if(!empty($info['phone'])) {
			$data['phone']=$info['phone'];
		}
		if(!empty($info['name'])) {
			$data['name']=$info['name'];
		}
		
		if(!empty($info['registration_no'])) {
			$data['registration_no']=$info['registration_no'];
		}
		if(!empty($info['logo'])) {
				$data['logo']=$this->docupload($info);
				
		//$data['logo']=$this->doupload();
		}
		$this->db->where('garage_id', $info['garage_id']);
		$this->db->update($this->table_emp, $data);
		
		return true;

	}
	
	function mail_exists($key)
	{
		$this->db->where('email',$key);
		$query = $this->db->get('employer_details');
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
    $query = $this->db->get('employer_details');
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