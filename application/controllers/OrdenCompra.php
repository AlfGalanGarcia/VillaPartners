<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class OrdenCompra extends CI_Controller 
{
    public $data = array();    
    public $datosVista = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('OrdenCompraTemporal_model');
        $this->load->model('OrdenCompra_model');
        

        $this->data['NroOC'] = $this->input->post('input_NroOC');
        $this->data['FechaEmisionOC'] = date('Y-m-d', strtotime($this->input->post('input_FechaEmisionOC')));
        $this->data['FechaPagoOC'] = date('Y-m-d', strtotime($this->input->post('input_FechaPagoOC')));
        $this->data['RucOC'] = $this->input->post('input_RucOC');
        $this->data['ProveedorOC'] = $this->input->post('input_ProveedorOC');
        $this->data['ConceptoOC'] = $this->input->post('input_ConceptoOC');
        $this->data['IdMonedaOC'] = $this->input->post('input_IdMonedaOC');
        $this->data['MontoOC'] = $this->input->post('input_MontoOC');
        $this->data['MontoIGVOC'] = $this->input->post('input_MontoIGVOC');
        $this->data['MontoTotalOC'] = $this->input->post('input_MontoTotalOC');
        $this->data['IdEstado'] = $this->input->post('input_IdEstado');
        $this->data['IdArchivoPagos'] = $this->input->post('input_IdArchivoPagos');    
    }

    public function index()
    {          
        $this->datosVista['ordenCompra']=$this->OrdenCompraTemporal_model->get_all_ordenCompra();          
        $this->load->view('ordenCompra_view',$this->datosVista);
    }

    public function agregar_OC()
    {
        $this->OrdenCompraTemporal_model->agregar_OC($this->data);
        echo json_encode(array("status" => TRUE));        
    }

    public function editar_archivoPagos($id)
    {
        $data = $this->OrdenCompraTemporal_model->get_by_id($id);     
        echo json_encode($data);
    }

    public function buscar_oc($oc)
    {
        $data = $this->OrdenCompra_model->get_oc($oc);

        if (!$data) 
        {
           echo json_encode($data);
        }
        else
        {
            $data->FechaEmisionOC = ($data->FechaEmisionOC == '0000-00-00') ? '' : date('d-m-Y', strtotime($data->FechaEmisionOC));
            //$data->FechaPago = ($data->FechaPago == '0000-00-00') ? '' : date('d-m-Y', strtotime($data->FechaPago));
            echo json_encode($data);
        }
    }

    public function eliminar_OC($id)
    {
        $this->OrdenCompraTemporal_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}