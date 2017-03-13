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
        $this->db->order_by('municipio','ASC');
        $query = $this->db->get('seccionales');
        return $query->result();
        
    }
    
    public function getSeccionById($id){
        $this->db->select('seccion');
        $this->db->where('id',$id);
        $query=$this->db->get('seccionales');
        
        if(count($query->num_rows())!=0){
            $seccional='';
          foreach($query->result() as $row){
              $seccional = $row->seccion;
          }  
            return $seccional;
        }else{
            return false;
        }
            
    }

}