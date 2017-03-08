<?php
class Seccion_model extends CI_Model
{     
	
	 
	function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
	
    public function getCoordinates($id){
     $this->db->select('coordinates');
     $this->db->where('id',$id);   
     $query=$this->db->get('seccionales');
     return $query->result();
    }
    
    public function getSecciones(){
        $this->db->select('id,seccion');
        $this->db->limit('0,100');
        $query = $this->db->get('seccionales');
        return $query->result();
        
    }

}