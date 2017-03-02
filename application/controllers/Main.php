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
    public function searchDistrito(){
        $distrito = $this->input->post('distrito');
        $this->getCoordinates($distrito);
    }
  
}
