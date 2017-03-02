<?php
class Usuarios_model extends CI_Model
{     
	
	 
	function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
	
    public function create($data){
        
    $this->db->insert('usuarios',$data);
    }
    
    function ValidarUsuario($email,$password){         //   Consulta Mysql para buscar en la tabla Usuario aquellos usuarios que coincidan con el mail y password ingresados en pantalla de login
      $query = $this->db->where('user',$email);   //   La consulta se efectúa mediante Active Record. Una manera alternativa, y en lenguaje más sencillo, de generar las consultas Sql.
      $query = $this->db->where('password',$password);
      $query = $this->db->get('usuarios');
      return $query->row();    //   Devolvemos al controlador la fila que coincide con la búsqueda. (FALSE en caso que no existir coincidencias)
   }

}