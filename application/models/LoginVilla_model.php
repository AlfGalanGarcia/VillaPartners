<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginVilla_model extends CI_Model 
	{
        public function __construct()
        {
            parent::__construct();           
            $this->load->database();
        }
        

        public function acceder($user,$password)
        {           
			$condition = "Alias =" . "'" . $user . "' AND " . "clave =" . "'" . $password . "'";
			$this->db->select('*');
			$this->db->from('empleado');
			$this->db->where($condition);
			$this->db->limit(1);
			$query = $this->db->get();		

			if ($query->num_rows() == 1) 
			{
				
				$datos = $query->result()[0];
				$datosSesion = array(
                   'empleado'  	=> $datos->Nombres." ".$datos->ApePaterno,
                   'alias'     	=> $datos->Alias,
                   'id'     	=> $datos->IdEmpleado,
                   'rol'     	=> $datos->Rol,
                   'logged_in' 	=> TRUE
               );
				$this->session->set_userdata($datosSesion);
				return true;
			} 
			else 
			{
				return false;
			}	
		}	
}