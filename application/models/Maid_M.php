<?php
Class Maid_M extends CI_Model {
	private $table_emp='maid_details';
	private $table_address='address_module';
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
	public function viewMaid($id) {
		$this->db->select('*');
		//$this->db->from($this->table);
		//$this->db->join('address_module', 'garage_module.address_id = address_module.id', "LEFT");
		$query = $this->db->get_where($this->table_emp, array("id"=>$id));
		$val = count($query->result());
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
	
	public function maidsList($info) {
		$this->db->distinct('booking_requests.maid_id');

		$this->db->select('maid_id');
		//$this->db->from($this->table);
		//$this->db->order_by("maid_details.id","desc");
		//$this->db->join('booking_requests', 'maid_details.id = booking_requests.maid_id', "LEFT");
		//$query = $this->db->get_where('maid_details', array("booking_requests.apartment"=>$info['apartment']));
		$query = $this->db->get_where('booking_requests', array("apartment"=>$info['apartment']));
		//$query = $this->db->get('booking_requests');
		
		$val = count($query->result());
		if($val>=1) {
			

		$maids = $query->result();
		}
		else  {
			
			$this->db->select('id');
		//$this->db->from($this->table);
		//$this->db->order_by("maid_details.id","desc");
		//$this->db->join('booking_requests', 'maid_details.id = booking_requests.maid_id', "LEFT");
		//$query = $this->db->get_where('maid_details', array("booking_requests.apartment"=>$info['apartment']));
		$query = $this->db->get_where('maid_details', array("status ="=>NULL));
		//$query = $this->db->get('booking_requests');
		
		$val = count($query->result());
		$maids = $query->result();
		}
		$a = array();
		//print_r($maids);
		foreach($maids as $maid) {
			$time_slots = $this->check_available_slots($maid->id);
			$b = $this->viewMaid($maid->id);
			$b['ava_time_slots']= $time_slots;
			//print_r($time_slots);
			array_push($a,$b);

		}
		
			return $a;
		

	}
	
	
	
	public function addInfo($info) {
			
		/* $this->db->select('address_id');
		$query = $this->db->get_where($this->table, array("invoice_id"=>$info['id']));
		$aid = ($query->row()->address_id); */
		if(!empty($info['first_name'])) {
			 $add_data['first_name']= $info['first_name'];
		}
		if(!empty($info['last_name'])) {
			$add_data['last_name']=$info['last_name'];
		}
		if(!empty($info['phone'])) {
			$add_data['phone']=$info['phone'];
		}
		if(!empty($info['voter_id_proof'])) {
			$add_data['voter_id_proof']=$this->docupload($info['voter_id_proof']);
		}
		if(!empty($info['aadhaar_id_proof'])) {
			$add_data['aadhaar_id_proof']=$this->docupload($info['aadhaar_id_proof']);
		}
		if(!empty($info['permanent_address'])) {
			$add_data['permanent_address']=$info['permanent_address'];
		}
		if(!empty($info['current_residance'])) {
			$add_data['current_residance']=$info['current_residance'];
		}
		if(!empty($info['mothers_name'])) {
			$add_data['mothers_name']=$info['mothers_name'];
		}
		if(!empty($info['fathers_husband_name'])) {
			$add_data['fathers_husband_name']=$info['fathers_husband_name'];
		}
		if(!empty($info['total_experience'])) {
			$add_data['total_experience']=$info['total_experience'];
		}
		if(!empty($info['children_no'])) {
			$add_data['children_no']=$info['children_no'];
		}
		if(!empty($info['photo'])) {
			$add_data['photo']=$this->docupload($info['photo']);
		}
		$this->db->insert('maid_details',$add_data);
		$id = $this->db->insert_id();

		
		
		return true;

	}
	
	public function addStatus($info) {
			
		/* $this->db->select('address_id');
		$query = $this->db->get_where($this->table, array("invoice_id"=>$info['id']));
		$aid = ($query->row()->address_id); */
		if(!empty($info['status'])) {
			 $add_data['status']= $info['status'];
		}
		if(!empty($info['maid_id'])) {
			 $add_data['maid_id']= $info['maid_id'];
		}
		$this->db->insert('attendance_details',$add_data);
		$id = $this->db->insert_id();

		
		
		return true;

	}
	
	
	public function addBooking($info) {
			
		/* $this->db->select('address_id');
		$query = $this->db->get_where($this->table, array("invoice_id"=>$info['id']));
		$aid = ($query->row()->address_id); */
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
			 $add_data['flat_num']= $info['flat_num'];
		}
		if(!empty($info['time_slots'])) {
			 $add_data['time_slots']= $info['time_slots'];
		}
		if(!empty($info['flat_type'])) {
			 $add_data['flat_type']= $info['flat_type'];
		}
		$this->db->insert('booking_requests',$add_data);
		$id = $this->db->insert_id();
		$this->db->where('maid_id', $info['maid_id']);
		 $add_data1['status']= $info['hired'];
		$this->db->update('maid_details', $add_data1);
		return true;
	}
	
		public function startJob($info) {
			
		/* $this->db->select('address_id');
		$query = $this->db->get_where($this->table, array("invoice_id"=>$info['id']));
		$aid = ($query->row()->address_id); */
		if(!empty($info['maid_id'])) {
			 $add_data['maid_id']= $info['maid_id'];
		}
		if(!empty($info['emp_id'])) {
			 $add_data['emp_id']= $info['emp_id'];
		}
		if(!empty($info['status'])) {
			 $add_data['status']= $info['status'];
		}
		//if(!empty($info['start_time'])) {
			$add_data['start_time']= date('d/m/Y h:i:s', time());
			  $add_data['date']= date('d/m/Y', time());
		//}
	
		$this->db->insert('attendance_details',$add_data);
		$id = $this->db->insert_id();
		return true;
	}
	
	
	
	public function endJob($info) {
			
		/* $this->db->select('address_id');
		$query = $this->db->get_where($this->table, array("invoice_id"=>$info['id']));
		$aid = ($query->row()->address_id); */
	
		if(!empty($info['status'])) {
			 $add_data['status']= $info['status'];
		}
		//if(!empty($info['start_time'])) {
			 $add_data['end_time']= date('d/m/Y h:i:s a', time());
		//}
	
		
		$this->db->where('emp_id', $info['emp_id']);
		$this->db->where('date', date('d/m/Y', time()));
		$this->db->update('attendance_details', $add_data);
		
		
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
	
	function check_available_slots($id) {
		$this->db->select('time_slots');
		//$this->db->from($this->table);
		//$this->db->order_by("maid_details.id","desc");
		//$this->db->join('booking_requests', 'maid_details.id = booking_requests.maid_id', "LEFT");
		$query = $this->db->get_where('booking_requests', array("maid_id"=>$id));
		//$query = $this->db->get('booking_requests');
		$this->db->select('time_slots');
		$query2 = $this->db->get('time_slots');
		$time_slots = $query2->result();	
		$val = count($query->result());
		
		if($val>=1 && !empty($id)) {
		$a = array();
		$maids = $query->result();	
		//print_r($maids);
		//$maids = (implode(',' ,$maids));
		

		
		 foreach($maids as $key){
        $keyToDelete = array_search($key, $time_slots);
        unset($time_slots[$keyToDelete]);
    }
			}
	 //$time_slots = json_encode($time_slots);

	//print_r($time_slots);
	//$str = implode(" ", $time_slots);

	return $time_slots;
	
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