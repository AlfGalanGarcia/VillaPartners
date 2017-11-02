<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Content-type: text/html; charset=utf-8");
class ModeloPrincipal_model extends CI_Model 
	{
		var $tablalocal = 'local';

        public function __construct()
        {
            parent::__construct();            
            $this->load->database();
        }

    public function get_empleado()
    {
        $query = $this->db->query('SELECT IdEmpleado, CONCAT(e.Nombres," ",e.ApePaterno) as nombres, alias from empleado e ORDER BY Nombres ASC');
        return $query->result();
    }

    public function get_empleadoLogin($user)
    {
        $query = $this->db->query('SELECT IdEmpleado, CONCAT(e.Nombres," ",e.ApePaterno) as nombres, alias from empleado e');
        $this->db->where('empleado.Alias',$user);
        return $query->result();
    }

    public function get_local()
    {
        $query = $this->db->query('SELECT Nombre from local');
        return $query->result();
    }     
        
}