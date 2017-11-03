<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class CajaChica_model extends CI_Model {
 
    var $tablaCajaChica = 'detallecajachica';
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
  
    public function get_all_cajaChica()
    {
        $query=$this->db->query('
            SELECT detallecajachica.*, tiposdoc.*, moneda.*, proveedor.*, igv.* FROM detallecajachica 
            INNER JOIN tiposdoc ON detallecajachica.IdTipoDoc = tiposdoc.IdTipoDoc
            INNER JOIN moneda ON detallecajachica.IdMoneda = moneda.IdMoneda
            INNER JOIN proveedor ON detallecajachica.IdProveedor = proveedor.IdProveedor
            INNER JOIN igv ON detallecajachica.IdIgv = igv.IdIgv
            ORDER BY FechaEmision DESC');

            return $query->result();        
    }

    public function registrar_documento($data)
    {
        
        $this->db->insert($this->tablaCajaChica, $data);
        return $this->db->insert_id();
    }



    public function delete_by_id($id)
    {
        $this->db->where('IdDetalleCC', $id);
        $this->db->delete($this->tablaCajaChica);
    }
}