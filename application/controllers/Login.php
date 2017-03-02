<?php

class Login extends CI_Controller {
 function __construct(){
        parent::__construct();
        $this -> load -> database();
        $this->load->helper('url');
    }
function index(){
        
      $this->load->view('login/login');
    }   
  
   function login($idioma=null)
   {
        
      //   $this->config->set_item('language', 'spanish');      //   Setear dinámicamente el idioma que deseamos que ejecute nuestra aplicación
      if(!isset($_POST['maillogin'])){   //   Si no recibimos ningún valor proveniente del formulario, significa que el usuario recién ingresa.   
         $this->load->view('login/login');      //   Por lo tanto le presentamos la pantalla del formulario de ingreso.
      }
      else{                        //   Si el usuario ya pasó por la pantalla inicial y presionó el botón "Ingresar"
         $this->form_validation->set_rules('maillogin','e-mail','required|valid_email');      //   Configuramos las validaciones ayudandonos con la librería form_validation del Framework Codeigniter
         $this->form_validation->set_rules('passwordlogin','password','required');
         if(($this->form_validation->run()==FALSE)){            //   Verificamos si el usuario superó la validación
            $this->load->view('login/login');                     //   En caso que no, volvemos a presentar la pantalla de login
         }
         else{                                       //   Si ambos campos fueron correctamente rellanados por el usuario,
            $this->load->model('usuarios_model');
                     $this->load->helper('security');

        $key = '1'.'0N!Zu|';
        $hash=do_hash($key);
        $this->crypt->Mode = Crypt::MODE_HEX;
        $this->crypt->Key  = $hash;
        $encrypted_user = $this->crypt->encrypt($_POST['maillogin']);
        $decrypted_user =  $this->crypt->decrypt($encrypted_user);
        $this->crypt->Mode = Crypt::MODE_HEX;
        $this->crypt->Key  = $hash;
        $encrypted_pass = $this->crypt->encrypt($_POST['passwordlogin']);
        $decrypted_pass =  $this->crypt->decrypt($encrypted_pass);
             
            $ExisteUsuarioyPassoword=$this->usuarios_model->ValidarUsuario($encrypted_user,$encrypted_pass);   //   comprobamos que el usuario exista en la base de datos y la password ingresada sea correcta
            if($ExisteUsuarioyPassoword){   // La variable $ExisteUsuarioyPassoword recibe valor TRUE si el usuario existe y FALSE en caso que no. Este valor lo determina el modelo.
               //echo "Validacion Ok<br><br><a href=''>Volver</a>";   //   Si el usuario ingresó datos de acceso válido, imprimos un mensaje de validación exitosa en pantalla
            $this->session->set_userdata("admin_login",$ExisteUsuarioyPassoword);
            if($ExisteUsuarioyPassoword->level == 1) {   
     redirect('/main/index', 'refresh');
            }
            }
            else{   //   Si no logró validar
               $data['error']="E-mail o password incorrecta, por favor vuelva a intentar";
               $this->load->view('login/login',$data);   //   Lo regresamos a la pantalla de login y pasamos como parámetro el mensaje de error a presentar en pantalla
            }
         }
      }
   }
    
    public function logout() {
        $this->session->unset_userdata("admin_login");
        $this->load->view('login/login');
    }
    
}
?>