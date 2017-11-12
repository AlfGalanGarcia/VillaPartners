<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Content-type: text/html; charset=utf-8");
class ModeloPrincipal_model extends CI_Model 
	{
		var $tablaEmpleado = 'empleado';

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

    public function get_local()
    {
        $query = $this->db->query('SELECT Nombre from local');
        return $query->result();
    }   

    public function get_banco()
    {
        $query = $this->db->query('SELECT IdBanco, NombreBanco, NroCtaCteVC from banco');
        return $query->result();
    }     

    public function get_tipoDoc()
    {
        $query = $this->db->query('SELECT IdTipoDoc, DescripcionTipoDoc from tiposdoc');
        return $query->result();
    }   

    public function get_proveedor()
    {
        $query = $this->db->query('SELECT IdProveedor, NombreProveedor from proveedor');
        return $query->result();
    }     
       
    public function get_moneda()
    {
        $query = $this->db->query('SELECT IdMoneda, DescripcionMoneda, AbreviaturaMoneda from moneda');
        return $query->result();
    } 

    public function get_tipoCambio()
    {
        $query = $this->db->query('SELECT IdTipoCambio, valorTC, fechaTC from tipocambio');
        return $query->result();
    } 

    public function get_IGV()
    {
        $query = $this->db->query('SELECT IdIgv, valor from igv');
        return $query->result();
    } 

    public function get_montoCajaChica()
    {
        $query = $this->db->query('SELECT MontoCC from cajachica');
        $datos = $query->result()[0];
        $datosSesion = array(
                   'MontoCC'  => $datos->MontoCC
               );
        $this->session->set_userdata($datosSesion);
        return $query->result();
    } 
}