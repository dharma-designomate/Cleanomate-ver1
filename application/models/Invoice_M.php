<?php
Class Invoice_M extends CI_Model {
	private $table='invoice_module';
	 public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
		$this->load->helper('date');

    }
	public function generateId() {
			$data=array(
			'date'=>date('Y-m-d',now()),
			'start_time'=>date('Y-m-d H:i:s',now())
			);
			$this->db->insert($this->table,$data);
			$insert_id = $this->db->insert_id();
			if($insert_id) {
			$query = $this->db->get_where($this->table, array("invoice_id"=>$insert_id));
			$start_time = ($query->row()->start_time);
			$data1['invoice_id']=$insert_id;
			$data1['start_time']=$start_time;
			return $insert_id;
		} else {
			return false;
		}

	}
	
	public function addInfo($info) {
			
		/* $this->db->select('address_id');
		$query = $this->db->get_where($this->table, array("invoice_id"=>$info['id']));
		$aid = ($query->row()->address_id); */
		
		if(!empty($info['garage_id'])) {
			 $data['garage_id']= $info['garage_id'];
		}
		if(!empty($info['car_id'])) {
			$data['car_id']=$info['car_id'];
		}
		if(!empty($info['customer_id'])) {
			$data['customer_id']=$info['customer_id'];
		}
		if(!empty($info['employee_id'])) {
			$data['employee_id']=$info['employee_id'];
		}
		if(!empty($info['smog_no'])) {
			$data['smog_no']=$info['smog_no'];
		}
		if(!empty($info['test_ids'])) {
			$data['test_ids']=$info['test_ids'];
		}
		if(!empty($info['test_status_id'])) {
			$data['test_status_id']=$info['test_status_id'];
		}
		if(!empty($info['transaction_id'])) {
			$data['transaction_id']=$info['transaction_id'];
		}
		if(!empty($info['invoice_status'])) {
			$data['invoice_status']=0;
		}
		if(!empty($info['reason'])) {
			$data['reason']=$info['reason'];
		}
		if(!empty($info['accountid'])) {
			$data['accountid']=$info['accountid'];
		}
		if(!empty($info['owner_fname'])) {
			$data['owner_fname']=$info['owner_fname'];
		}if(!empty($info['owner_lname'])) {
			$data['owner_lname']=$info['owner_lname'];
		}
		if(!empty($info['odometer'])) {
			$data['odometer']=$info['odometer'];
		}
		if(!empty($info['vin_no'])) {
			$data['vin_no']=$info['vin_no'];
		}
		if(!empty($info['po'])) {
			$data['po']=$info['po'];
		}
		if(!empty($info['registrationDueDate'])) {
			$data['registrationDueDate']=$info['registrationDueDate'];
		}
		if(!empty($info['referred_from'])) {
			$data['referred_from']=$info['referred_from'];
		}
		
		if(!empty($info['Document_Urls'])) {
			$data['Document_Urls']=$info['Document_Urls'];
		}
		if(!empty($info['total_amount'])) {
			$data['total_amount']=$info['total_amount'];
		}
		if(!empty($info['service'])) {
			$data['service_name']=$info['service'];
		}
		
		$this->db->where('invoice_id', $info['estimateId']);
		$this->db->update($this->table, $data);
		
		return  $info['estimateId'];

	}
	
	
	public function update($info) {
			
		/* $this->db->select('address_id');
		$query = $this->db->get_where($this->table, array("invoice_id"=>$info['id']));
		$aid = ($query->row()->address_id); */
		$data['invoice_status']=$info['invoice_status'];
		$this->db->where('invoice_id', $info['invoice_id']);
		$this->db->update($this->table, $data);
		
		return  true;

	}
	
	
	
	
	function viewList($filter) {
	
	unset($filter['key']);
	if(isset($filter['business_id']) && isset($filter['garage_id'])) {
	$garages_id = $this->findGarageId($filter['business_id']);
	foreach($garages_id as $garage_id) {
	 $garages[] = $garage_id->garage_id;
	}
	$garages[] = $filter['garage_id'];
	unset($filter['garage_id']);
	unset($filter['business_id']);
	}
	
	else if(isset($filter['business_id'])) {
	$garages_id = $this->findGarageId($filter['business_id']);
	foreach($garages_id as $garage_id) {
	 $garages[] = $garage_id->garage_id;
	}
	
	$this->db->select('*');
	
	$this->db->where_in('invoice_module.garage_id',$garages );
		unset($filter['business_id']);
	} 
	
	if(count($filter)>0){ 
	foreach($filter as $key => $value) {
	$this->db->where('invoice_module.'.$key,$value);
	}
	}
	$this->db->join('garage_module', 'invoice_module.garage_id = garage_module.garage_id','Inner');
	$this->db->join('car_module', 'invoice_module.customer_id = car_module.customer_id','Inner');
	$this->db->join('customer_module', 'invoice_module.customer_id = customer_module.customer_id','Inner');

	$this->db->join('address_module', 'customer_module.address_id = address_module.id','Inner');

	 $query = $this->db->get($this->table);
	// print_r($query);
    if ($query->num_rows() > 0){
        return ($query->result());
    }
    else {
        return false;
    }
	}
	
	function docupload($info) {
		$invoice_id=$info['invoice_id'];
		$images=$info['userdocs'];
		  $upPath=APPPATH.'../assets/userdocs/images/'; 
		define('UPLOAD_DIR', $upPath);
		foreach($images as $image) {
			$userinfo['userdocs'] = $image['imagedata'];
			$userinfo['name'] = $image['name'];
			$userinfo['invoice_id'] =$invoice_id;
			$msg[]=$this->docsave($userinfo);
		}
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
			//return $imagename;
			$data=array(
			'invoice_id'=>$info["invoice_id"],
			'documents'=>$imagename
			);
			$this->db->insert('documents',$data);
			$msg["success"]=$info['name']." Saved";
			
		} else {
			$msg["error"]=$info['name']." Failed";
			
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
			//return $imagename;
			$data=array(
			'invoice_id'=>$info["invoice_id"],
			'documents'=>$imagename
			);
			$this->db->insert('documents',$data);
			$msg["success"]=$info['name']." Saved";
			
		} else {
			$msg["error"]=$info['name']." Failed";
			
		}
		}
		else {
			$msg["error"]=$info['name']." Failed";
			
		}
	  return $msg;
	   }
	 }
	
	function retrieveExtension($data){
 
$pos  = strpos($data, ';');
$type = explode(':', substr($data, 0, $pos))[1];

    return $type;

	}

	
	function findGarageId($business_id) {
	$this->db->select('*');
	$this->db->from('garage_module');
	$this->db->where('business_id',$business_id);

	$query = $this->db->get();
		if ($query->num_rows() > 0){
		return ($query->result()); 
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