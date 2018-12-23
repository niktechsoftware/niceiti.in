<?php class feeduemodel extends CI_Model{
	public function getDueDetail(){
		$query1 = $this->db->get("feedue");
		return $query1;
	}
	
	public function enterDetail($data,$studid){
		$this->db->where("student_id",$studid);
		$var=$this->db->get("feedue");
		if($var->num_rows() > 0)
		{
		$this->db->where("student_id",$studid);
		$this->db->update("feedue",$data);
		}
		else{
		$var = $this->db->insert("feedue",$data);
		}
		$this->db->insert("feedue2",$data);
		return $var;
	}
	
	public function enterDetail1($data,$studid){
		$this->db->where("student_id",$studid);
		$var=$this->db->get("examdue");
		if($var->num_rows() > 0)
		{
			$this->db->where("student_id",$studid);
			$this->db->update("examdue",$data);
		}
		else{
			$var = $this->db->insert("examdue",$data);
		}
		$this->db->insert("examdue2",$data);
		return $var;
	}
	
	public function checkStock($studentId){
		$this->db->where("student_id",$studentId);
		$var=$this->db->get("feedue");
		return $var;
	
	}
	public function checkStock2($studentId){
			$this->db->where("enroll_num",$studentId);
		$var1=$this->db->get("student_info");
		return $var1;
		
	}
	 public function checkStock1($studentId){
		$this->db->where("student_id",$studentId);
		$var=$this->db->get("examdue");
		return $var;
	
	}

	
}