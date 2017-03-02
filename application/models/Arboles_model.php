<?php
class Arboles_model extends CI_Model
{     
	
	 
	function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
	
    public function getArboles($id_municipio){
        
     $this->db->select('FID_,OBJECTNo,ID_ESPECIE,NOMBRE,SINONIMOS,NOMB_CIENTIFICO,DIAMETRO_C,ALTURA_M,EDAD,ESTADO_FIT,ACCION_A_R,AFECTACION,AFEC_BANQUETA,AFEC_GUARNICION,AFEC_CABLEADO,AFEC_CALLE,AFEC_DRENAJE,AFEC_ALUMBRADO,AFEC_CONSTRUCCION,AFEC_CAMELLON,AFEC_RED_GAS,AFEC_ALINEAMIENTO,AFEC_VARIAS,EDO_GRAL,OBSERVACIONES,CRITERIOSS,LUGAR,COMUNIDAD,TIPO,FECHA_LECT,ALTITUD,UTM,X1,Y1,LATITUDE,LONGITUDE,ID_DELEGA,nose,DELEGACION,INDICADOR');
        
    $query=$this->db->get($id_municipio);
    return $query->result();
    }

}