<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ArchivoPagos extends CI_Controller 
{
	public $data = array();    
    public $datosVista = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ArchivoPagos_model');
        $this->load->model('ModeloPrincipal_model');
        $this->load->model('OrdenCompra_model');
        $this->load->helper('form');

        $this->data['FechaCreacion'] = date('Y-m-d', strtotime($this->input->post('input_FechaCreacion')));
        $this->data['IdArchivoPagos'] = $this->input->post('input_IdArchivoPagos');        
        $this->data['IdEstado'] = $this->input->post('input_Estado');
        $this->data['IdMoneda'] = $this->input->post('input_IdMoneda');

        $this->datosVista['archivoPagos']=$this->ArchivoPagos_model->get_all_archivoPagos(); 
        $this->datosVista['ordenCompra']=$this->OrdenCompra_model->get_all_ordenCompra(); 
        $this->datosVista['sumaMontoTotalOC']=$this->OrdenCompra_model->get_all_montosOC(); 
        $this->datosVista['empleadoLogin']=$this->ModeloPrincipal_model->get_empleado();   
        $this->datosVista['local']=$this->ModeloPrincipal_model->get_local(); 	
    }

    public function index()
    {
        $this->load->helper('url');
        $this->load->view('header_view');                      
        $this->load->view('nav_view',$this->datosVista);                      
        $this->load->view('archivoPagos_view',$this->datosVista);
    }

    public function generar_archivoPagos()
    {
        $this->ArchivoPagos_model->generar_archivoPagos($this->data);
        echo json_encode(array("status" => TRUE));        
    }

    public function preaprobar_archivoPagos($id)
    {

        $this->ArchivoPagos_model->preaprobar_archivoPagos($id,array('IdEstado' => '3'));
        echo json_encode(array("status" => TRUE));

    }

    public function editar_archivoPagos($id)
    {
        $data = $this->ArchivoPagos_model->get_by_id($id);        
        echo json_encode($data);
    }

    public function eliminar_archivoPagos($id)
    {
        $this->ArchivoPagos_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}