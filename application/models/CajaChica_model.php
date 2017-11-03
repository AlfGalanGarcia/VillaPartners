<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class CajaChica_model extends CI_Model {
 
    var $tablaDetalleCC = 'detallecajachica';
    var $tablaCajaChica = 'cajachica';
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
  
    public function get_all_cajaChica()
    {
        $query=$this->db->query('
            SELECT detallecajachica.*, tiposdoc.*, moneda.*, proveedor.*, igv.*, cajachica.* FROM detallecajachica 
            INNER JOIN tiposdoc ON detallecajachica.IdTipoDoc = tiposdoc.IdTipoDoc
            INNER JOIN moneda ON detallecajachica.IdMoneda = moneda.IdMoneda
            INNER JOIN proveedor ON detallecajachica.IdProveedor = proveedor.IdProveedor
            INNER JOIN igv ON detallecajachica.IdIgv = igv.IdIgv
            INNER JOIN cajachica ON cajachica.IdCajaChica = detallecajachica.IdCajaChica
            ORDER BY FechaEmision DESC');

            return $query->result();        
    }

    public function get_by_id($id)
    {
        $this->db->from($this->tablaDetalleCC);
        $this->db->where('detallecajachica.IdDetalleCC',$id);       
        $query = $this->db->get();
 
        return $query->row();
    }

    public function registrar_documento($data)
    {
        
        $this->db->insert($this->tablaDetalleCC, $data);
        return $this->db->insert_id();
    }

    public function actualizar_cajachica($where,$data)
    {
        $this->db->update($this->tablaCajaChica, $data, $where);
        return $this->db->affected_rows();
    }

    public function actualizar_documento($where,$data)
    {
        $this->db->update($this->tablaDetalleCC, $data, $where);
        return $this->db->affected_rows();
    }


    public function delete_by_id($id)
    {
        $this->db->where('IdDetalleCC', $id);
        $this->db->delete($this->tablaDetalleCC);
    }
}