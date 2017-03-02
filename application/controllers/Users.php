<?php
class  Users  extends CI_Controller
{
    
      function __construct(){
        parent::__construct();

    
      
        $this->load->helper('url');
    }
    function index(){
        
      
    }   
    
    public function createUser(){
        $this->load->model('usuarios_model');
        $this->load->helper('security');
        $usuario = $this->input->get('usuario');
        $clave = $this->input->get('clave');
        $level= $this->input->get('level');
        $real_name = $this->input->get('real');
        $key = '1'.'0N!Zu|';
        $hash=do_hash($key);
        $this->crypt->Mode = Crypt::MODE_HEX;
        $this->crypt->Key  = $hash;
        $encrypted_user = $this->crypt->encrypt($usuario);
        $decrypted_user =  $this->crypt->decrypt($encrypted_user);
        $this->crypt->Mode = Crypt::MODE_HEX;
        $this->crypt->Key  = $hash;
        $encrypted_pass = $this->crypt->encrypt($clave);
        $decrypted_pass =  $this->crypt->decrypt($encrypted_pass);
        $data=array(
        'user' => $encrypted_user,
        'password' => $encrypted_pass,
        'level' => $level,
        'real_name' =>$real_name  
        );
        $this->usuarios_model->create($data);
        
  }
    
    
}
