<?php
Class Garage_M extends CI_Model {
	private $table_emp='garage_module';
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
	public function viewGarage($id) {
		$this->db->select('*');
		//$this->db->from($this->table);
		$this->db->join('address_module', 'garage_module.address_id = address_module.id', "LEFT");
		$query = $this->db->get_where($this->table_emp, array("garage_id"=>$id));
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
	
	public function addInfo($info) {
			
		/* $this->db->select('address_id');
		$query = $this->db->get_where($this->table, array("invoice_id"=>$info['id']));
		$aid = ($query->row()->address_id); */
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
		if(!empty($info['email'])) {
			$data['email']=$info['email'];
		}
		if(!empty($info['phone'])) {
			$data['phone']=$info['phone'];
		}
		if(!empty($info['name'])) {
			$data['name']=$info['name'];
		}
			$data['address_id']=$id;
		
		if(!empty($info['registration_no'])) {
			$data['registration_no']=$info['registration_no'];
		}
		
		if(!empty($info['logo'])) {
			$data['logo']=$this->docupload($info);
		}
		
		$this->db->insert('garage_module',$data);
		
		return true;

	}
	
	public function doupload()
     {
       $upPath=FCPATH.'assets/userdoc/images/'; 
	   if(isset($_REQUEST["logo"])) {
		   
		define('UPLOAD_DIR', $upPath);
		$img = $_REQUEST['logo'];
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
		
		$images=$info['logo'];
		$upPath=APPPATH.'../assets/userdocs/images/'; 
		define('UPLOAD_DIR', $upPath);
	
			$userinfo['userdocs'] = $info['logo'];
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
	
	
	public function verify_key($key) {
		
		if($key=='t1E1a6p3j2') {
			return true;
		}
		else {
			return false;
		}
	}
}