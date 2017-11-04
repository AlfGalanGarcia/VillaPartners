<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class OrdenCompra_model extends CI_Model {
     
    var $tablaOrdenCompra = 'ordencompra';
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_oc($oc)
    {
        $this->db->from($this->tablaOrdenCompra);
        $this->db->where('ordencompra.NroOC',$oc);
        $this->db->join('moneda', 'ordencompra.IdMonedaOC = moneda.IdMoneda');
        $this->db->join('proveedor', 'ordencompra.ProveedorOC = proveedor.IdProveedor');
        $query = $this->db->get();
 
        return $query->row();
    }
}