<?php
class Distrito_model extends CI_Model
{     
	
	 
	function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
	
    public function getCoordinates($id){
        
     $this->db->select('coordinates');
     $this->db->where('id',$id);   
     $query=$this->db->get('distritos');
     return $query->result();
    }
    
    public function getDistritos(){
        $this->db->select('id,name');
        $query = $this->db->get('distritos');
        return $query->result();
        
    }

}