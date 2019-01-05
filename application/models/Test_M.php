<?php
Class Test_M extends CI_Model {
	private $table='test_list';
	 public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
		$this->load->helper('date');

    }
	
	function viewList($filter) {
	$this->db->select('*');
	$query = $this->db->get($this->table);
    if ($query->num_rows() > 0){
        return ($query->result());
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