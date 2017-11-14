<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CobrarCuenta extends CI_Controller 
{
	public $data = array(); 	
    public $datosVista = array();


    public function __construct()
    {
    	parent::__construct();
    	$this->load->model('ModeloPrincipal_model');
    	$this->load->model('CobrarCuenta_model');

    	$this->data['IdPedido'] = $this->input->post('input_IdPedido');  
    	$this->data['IdEmpleado'] = $this->input->post('input_IdEmpleado');  
    	$this->data['IdComprobante'] = $this->input->post('input_IdTipoDoc');  
    	$this->data['NroCliente'] = $this->input->post('input_NroCliente');  
    	$this->data['NombreCliente'] = $this->input->post('input_NombreCliente');  
    	$this->data['RucEmpresa'] = $this->input->post('input_RucEmpresa');  
    	$this->data['NombreEmpresa'] = $this->input->post('input_NombreEmpresa');  
    	$this->data['IdMoneda'] = $this->input->post('input_IdMoneda');  
    	$this->data['MontoEfectivo'] = $this->input->post('input_MontoEfectivo'); 
    	$this->data['MontoTarjeta'] = $this->input->post('input_MontoTarjeta'); 
    	$this->data['FechaVenta'] = date('Y-m-d', strtotime($this->input->post('input_FechaPedido')));
    	$this->data['HoraVenta'] = date('H:i:s', strtotime($this->input->post('input_HoraPedido')));

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

        $this->CobrarCuenta_model->cambiar_estado($id,array('IdEstadoPedido' => '10', 'IdEmpleadoSesion' => $this->session->userdata('id')));
        echo json_encode(array("status" => TRUE));
    }


    public function anular($id)
    {
        $this->CobrarCuenta_model->cambiar_estado($id,array('IdEstadoPedido' => '12', 'IdEmpleadoSesion' => $this->session->userdata('id')));
        echo json_encode(array("status" => TRUE));
    }

    public function pagar()
    {
	
       	$this->CobrarCuenta_model->cambiar_estado($this->input->post('input_IdPedido'),array('IdEstadoPedido' => '11', 'IdEmpleadoSesion' => $this->session->userdata('id')));
        $this->CobrarCuenta_model->pagar($this->data);
        echo json_encode(array("status" => TRUE));
    }
}    