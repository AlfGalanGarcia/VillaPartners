<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CobrarCuenta extends CI_Controller 
{
	

    public function __construct()
    {
    	parent::__construct();
    	$this->load->model('ModeloPrincipal_model');
    	$this->load->model('CobrarCuenta_model');

        $this->datosVista['local']=$this->ModeloPrincipal_model->get_local(); 	        
        $this->datosVista['observados']=$this->ModeloPrincipal_model->get_observados();
        $this->datosVista['tipoDoc']=$this->ModeloPrincipal_model->get_tipoDoc();
		$this->datosVista['moneda']=$this->ModeloPrincipal_model->get_moneda();
		$this->datosVista['tc']=$this->ModeloPrincipal_model->get_tipoCambio();
    }

	public function index()
    {
    	$this->datosVista['pedidoMesa']=$this->CobrarCuenta_model->get_all_pedidoMesa(); 
        $this->load->helper('url');
        $this->load->view('header_view');                      
        $this->load->view('nav_view',$this->datosVista);                      
        $this->load->view('cobrarCuenta_view',$this->datosVista);
    }

	public function venta($id)
    {
    	$this->datosVista['detallePedido']=$this->CobrarCuenta_model->get_detalle_pedido($id);
        $this->load->helper('url');
        $this->load->view('header_view');                      
        $this->load->view('nav_view',$this->datosVista);                      
        $this->load->view('venta_view',$this->datosVista);
    }


	public function precuenta($id)
    {

        $this->CobrarCuenta_model->precuenta($id,array('IdEstadoPedido' => '10', 'IdEmpleadoSesion' => $this->session->userdata('id')));
        echo json_encode(array("status" => TRUE));
    }
}    