<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Caja_model extends CI_Model 
	{
		var $tablaCaja = 'caja';

    public function __construct()
    {
        parent::__construct();            
        $this->load->database();
    }

    public function get_caja()
    {
        $query = $this->db->query('SELECT caja.*, estado.* from caja
            INNER JOIN estado ON caja.IdEstadoCaja = estado.IdEstado
            ');
        return $query->result();
    }

    public function cerrar_caja($id, $data)
    {
        $this->db->where('IdCaja', $id);
        $this->db->update($this->tablaCaja, $data);
        return $this->db->affected_rows();
    }
}