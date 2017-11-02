<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class ArchivoPagos_model extends CI_Model {
 
    var $tablaArchivoPagos = 'archivopagos';
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
  
    public function get_all_archivoPagos()
    {
        //$this->db->from($this->tablaArchivoPagos);
        $query=$this->db->query('
            SELECT archivoPagos.*, estado.*, moneda.* FROM archivoPagos 
            INNER JOIN estado ON archivoPagos.IdEstado = estado.IdEstado
            INNER JOIN moneda ON archivoPagos.IdMoneda = moneda.IdMoneda
            ORDER BY FechaCreacion DESC');
        if($query->num_rows() > 0){
            return $query->result();
        } else {
            return $query->result_array();
        }
        
    }

    public function generar_archivoPagos($data)
    {
        
        $this->db->insert($this->tablaArchivoPagos, $data);
        return $this->db->insert_id();
    }

    public function preaprobar_archivoPagos($id, $data)
    {
        $this->db->where('IdArchivoPagos', $id);
        $this->db->update($this->tablaArchivoPagos, $data);
        return $this->db->affected_rows();
    }

    public function get_by_id($id)
    {
        $this->db->from($this->tablaArchivoPagos);
        $this->db->where('archivopagos.IdArchivoPagos',$id);
        $this->db->join('estado', 'archivopagos.IdEstado = estado.IdEstado');
        $query = $this->db->get();
 
        return $query->row();
    }

    public function delete_by_id($id)
    {
        $this->db->where('IdArchivoPagos', $id);
        $this->db->delete($this->tablaArchivoPagos);
    }
}