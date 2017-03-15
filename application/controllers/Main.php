<?php
class  Main  extends CI_Controller
{
    
      function __construct(){
        parent::__construct();

    
      
        $this->load->helper('url');
    }
    function index(){
        $this->load->model('distrito_model');
        $datos["distritos"]=$this->distrito_model->getDistritos();
        $this->load->view('main/index3',$datos);
      
    }   
    function goSecciones(){
        $this->load->model('seccion_model');
        $this->load->model('distrito_model');
        $datos["distritos"]=$this->distrito_model->getDistritos();
        $datos["secciones"]=$this->seccion_model->getSecciones();
        $this->load->view('main/secciones',$datos);
    }
    public function getCoordinates($id){
        $this->load->model('Distrito_model');
        $resultado=$this->Distrito_model->getCoordinates($id);
        $data1= array();
        $coordenadas;
         foreach($resultado as $row){
         $coordinates = $row->coordinates;
         $coordenadas =  explode(",", $coordinates);
            }
        $data_total = array();
          for ($i = 0; $i < count($coordenadas); $i++) {
                array_push($data_total,$coordenadas[$i]);
        }
        $stack = array_pop($data_total);

        echo json_encode($data_total);
    }
    public function getCoordinatesSeccion($id){
        $this->load->model('Seccion_model');
        $resultado=$this->Seccion_model->getCoordinates($id);
        $data1= array();
        $coordenadas;
         foreach($resultado as $row){
         $coordinates = $row->coordinates;
         $coordenadas =  explode(",", $coordinates);
            }
        $data_total = array();
          for ($i = 0; $i < count($coordenadas); $i++) {
                array_push($data_total,$coordenadas[$i]);
        }
        
        $stack = array_pop($data_total);

        return $data_total;
    }
    public function getJovenes($seccional){
        $this->load->model('Jovenes_model');
        $resultado=$this->Jovenes_model->getJovenes($seccional);
        return $resultado;
    }
    public function searchDistrito(){
        $distrito = $this->input->post('distrito');
        $this->getCoordinates($distrito);
    }
    public function searchSeccion(){
       $this->load->model('Seccion_model');
        $seccion = $this->input->post('seccionales');
        $data_coordenadas = $this->getCoordinatesSeccion($seccion);
        $seccional = $this->Seccion_model->getSeccionById($seccion);
        $data_jovenes = $this->getJovenes($seccional);
        $response["coordenadas"] = $data_coordenadas;
        $response["jovenes"] = $data_jovenes;
        echo json_encode($response);
    }
    public function searchJovenes(){
        $this->load->model('Seccion_model');
        $id = $this->input->post('id_seccionaL');
        $seccional = $this->Seccion_model->getSeccionById($id);
        $data_jovenes = $this->getJovenes($seccional);
        $response["jovenes"] = $data_jovenes;
        echo json_encode($response);
    }
}
