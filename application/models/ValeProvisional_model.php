<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class ValeProvisional_model extends CI_Model {
 
    var $tablaValeProvisional = 'valeprovisional';
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_vale_provisional()
    {
        //$this->db->from('valeprovisional');
        $query=$this->db->query('
            SELECT valeprovisional.*, CONCAT(empleado.Nombres," ",empleado.ApePaterno) as nombres, estado.* FROM valeprovisional 
            INNER JOIN empleado ON valeprovisional.IdEmpleado = empleado.IdEmpleado
            INNER JOIN estado ON valeprovisional.IdEstado = estado.IdEstado
            ORDER BY FechaCreacion DESC');
        return $query->result();
    }
 
    public function get_by_id($id)
    {
        $this->db->from($this->tablaValeProvisional);
        $this->db->where('IdVale',$id);        
        $query = $this->db->get();
 
        return $query->row();
    }

 
    public function agregar_vale_provisional($data)
    {
        
        $this->db->insert($this->tablaValeProvisional, $data);
        return $this->db->insert_id();
    }

 
    public function actualizar_vale_provisional($where, $data)
    {
        $this->db->update($this->tablaValeProvisional, $data, $where);
        return $this->db->affected_rows();
    }


    public function delete_by_id($id)
    {
        $this->db->where('IdVale', $id);
        $this->db->delete($this->tablaValeProvisional);
    }

}