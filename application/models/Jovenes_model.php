<?php
class Jovenes_model extends CI_Model
{     
	
	 
	function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
	
    public function getJovenes($seccional){
        
     $this->db->select('*');
     $this->db->where('seccional',$seccional);   
     $query=$this->db->get('seccionales_jovenes');
     return $query->result();
    }

}