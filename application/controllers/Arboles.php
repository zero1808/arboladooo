<?php
class  Arboles  extends CI_Controller
{
    
      function __construct(){
        parent::__construct();

    
      
        $this->load->helper('url');
    }
    function index(){
        
      
        $this->load->view('arboles/index');
    }   
    
    public function getArboles(){
        $this->load->model('Arboles_model');
        $id_municipio=$this->input->post('id_municipio');
        $resultado=$this->Arboles_model->getArboles($id_municipio);
        $data1= array();
         foreach($resultado as $row){
        $data1["peticionario"][]="<h1>".$row->NOMBRE."</h1><table border='1px' bgcolor='#9FF781'><tr><td>IDENTIFICADOR UNICO: ".$row->FID_."</td><td>ESPECIE: ".$row->NOMBRE."</td><td>OTROS NOMBRES: ".$row->SINONIMOS."</td><td>NOMBRE CIENTIFICO: ".$row->NOMB_CIENTIFICO."</td></tr>"."<tr><td>DIAMETRO(CM): ".$row->DIAMETRO_C."</td><td>ALTURA(M) ".$row->ALTURA_M."</td><td>EDAD RELATIVA: ".$row->EDAD."</td><td>ESTADO FITOSANITARIO: ".$row->ESTADO_FIT."</td></tr>"."<tr><td>ACCION A REALIZAR: ".$row->ACCION_A_R."</td><td>DAÑO A BANQUETA: ".$row->AFEC_BANQUETA."</td><td>DAÑO A GUARNICION: ".$row->AFEC_GUARNICION."</td><td>DAÑO A CABLEADO: ".$row->AFEC_CABLEADO."</td></tr>"."<tr><td>DAÑO A LA CALLE: ".$row->AFEC_CALLE."</td><td>DAÑO AL DRENAJE: ".$row->AFEC_DRENAJE."</td><td>DAÑO AL ALUMBRADO: ".$row->AFEC_ALUMBRADO."</td><td>DAÑO A CONSTRUCCION: ".$row->AFEC_CONSTRUCCION."</td></tr>"."<tr><td>DAÑO A CAMELLON: ".$row->AFEC_CAMELLON."</td><td>DAÑO A RED GAS NATURAL: ".$row->AFEC_RED_GAS."</td><td>AFECTACION AL ALINEAMIENTO: ".$row->AFEC_ALINEAMIENTO."</td><td>AFECTACIONES VARIAS: ".$row->AFEC_VARIAS."</td></tr>"."<tr><td>ESTADO GENERAL: ".$row->EDO_GRAL."</td><td>OBSERVACIONES: ".$row->OBSERVACIONES."</td><td>LUGAR: ".$row->LUGAR."</td><td>COMUNIDAD: ".$row->COMUNIDAD."</td></tr>"."<tr><td>FECHA DE ULTIMO LEVANTAMIENTO: ".$row->FECHA_LECT."</td><td>ALTITUD: ".$row->ALTITUD."</td><td>UTM: ".$row->UTM."</td><td>X1: ".$row->X1."</td></tr>"."<td>Y1: ".$row->Y1."</td><td>LATITUD: ".$row->LATITUDE."</td><td>LONGITUD: ".$row->LONGITUDE."</td><td>DELEGACION: ".$row->DELEGACION."</td></tr></table>";
            
   
           $data1["latitud"][]=$row->LATITUDE;
           $data1["longitud"][]=$row->LONGITUDE;
            
        }
        
           echo json_encode($data1);
        
    }

    
}
