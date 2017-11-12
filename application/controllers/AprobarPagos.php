<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AprobarPagos extends CI_Controller 
{
	public $data = array();    
    public $datosVista = array();

    public function __construct()
    {
        parent::__construct();
		$this->load->model('ArchivoPagos_model');
		$this->load->model('AprobarPagos_model');
        $this->load->model('ModeloPrincipal_model');
        $this->load->model('OrdenCompraTemporal_model');
        
		$this->datosVista['archivoBanco']=$this->AprobarPagos_model->get_all_archivoBanco(); 
		$this->datosVista['datosAprobar']=$this->AprobarPagos_model->get_datos_aprobar('1'); 
        $this->datosVista['archivoPagos']=$this->ArchivoPagos_model->get_all_archivoPagos(); 
        $this->datosVista['ordenCompra']=$this->OrdenCompraTemporal_model->get_all_ordenCompra(); 
        $this->datosVista['sumaMontoTotalOC']=$this->OrdenCompraTemporal_model->get_all_montosOC(); 
        $this->datosVista['local']=$this->ModeloPrincipal_model->get_local(); 	
        $this->datosVista['banco']=$this->ModeloPrincipal_model->get_banco();
        
    }

    public function index()
    {
        $this->load->helper('url');
        $this->load->view('header_view');                      
        $this->load->view('nav_view',$this->datosVista);                      
        $this->load->view('AprobarPagos_view',$this->datosVista);
    }

    public function aprobar_pago($id)
    {

        $this->AprobarPagos_model->aprobar_pago($id,array('IdEstado' => '6'));
        echo json_encode(array("status" => TRUE));
    }

    public function generar_archivoPagos()
    {
        $this->ArchivoPagos_model->generar_archivoPagos($this->data);
        echo json_encode(array("status" => TRUE));        
    }

    public function generar_tabla_banco()
    {
    	//$data = array(); 
    /*    if ($this->form_validation->run() == FALSE) 
        {
            echo json_encode(validation_errors());
        } 
        else 
        {*/
        	$data = $this->input->post();
            $this->AprobarPagos_model->generar_tabla_banco($data);
            $this->AprobarPagos_model->aprobar_pago('1',array('IdEstado' => '8')); 
            echo json_encode(array("status" => TRUE));
        //}

    }
}