<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class OrdenCompraTemporal_model extends CI_Model {
 
    var $tablaOrdenCompraTemporal = 'tempoc';
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
  
    public function get_all_ordenCompra()
    {
        $this->db->from($this->tablaOrdenCompraTemporal);
        $query=$this->db->query('
            SELECT tempoc.*, estado.*, archivopagos.*, moneda.*, proveedor.* FROM tempoc 
            INNER JOIN estado ON tempoc.IdEstado = estado.IdEstado
            INNER JOIN archivopagos ON tempoc.IdArchivoPagos = archivopagos.IdArchivoPagos
            INNER JOIN moneda ON tempoc.IdMonedaOC = moneda.IdMoneda
            INNER JOIN proveedor ON tempoc.ProveedorOC = proveedor.IdProveedor
            ORDER BY FechaCreacion DESC');
        return $query->result();
    }

    public function get_all_montosOC()
    {
        $query=$this->db->query('
            SELECT SUM(tempoc.MontoOC)*1.18 AS sumaMontos FROM tempoc                     
            WHERE tempoc.IdEstado = 3 AND tempoc.IdArchivoPagos = 1');
        return $query->result();
    }

   public function agregar_OC($data)
    {
        
        $this->db->insert($this->tablaOrdenCompraTemporal, $data);
        $this->db->insert_id();
    }

    public function get_by_id($id)
    {        
        $this->db->from($this->tablaOrdenCompraTemporal);
        $this->db->where('tempoc.IdArchivoPagos',$id);
        $query = $this->db->get();
 
        return $query->row();
    }

    public function delete_by_id($id)
    {
        $this->db->where('NroOC', $id);
        $this->db->delete($this->tablaOrdenCompraTemporal);
    }
}