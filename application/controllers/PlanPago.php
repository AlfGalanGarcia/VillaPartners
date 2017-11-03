<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class PlanPago extends CI_Controller {

    public $data = array();    
    public $datosVista = array();
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PlanPago_model');
        $this->load->model('ModeloPrincipal_model');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('input_NroFactura', 'Numero factura', 'required|is_natural');
        $this->form_validation->set_rules('input_FechaPago', 'Fecha de pago', 'required');

        //Campos formulario
        $this->data['FechaPago'] = date('Y-m-d', strtotime($this->input->post('input_FechaPago')));
        $this->data['NroOC'] = $this->input->post('input_NroOC');
        $this->data['NroFactura'] = $this->input->post('input_NroFactura');
        $this->data['MontoPago'] = $this->input->post('input_MontoPago');
        $this->data['MontoIGV'] = $this->input->post('input_MontoIGV');
        $this->data['MontoTotal'] = $this->input->post('input_MontoTotal');
        $this->dataOC['ConceptoOC'] = $this->input->post('input_ConceptoOC');
        $this->dataOC['IdMonedaOC'] = $this->input->post('input_IdMonedaOC');
        //La fecha de emisión no se modifica $this->dataOC['FechaEmisionOC'] = $this->input->post('input_FechaEmisionOC');
        $this->dataOC['RucOC'] = $this->input->post('input_RucOC');
        $this->dataOC['ProveedorOC'] = $this->input->post('input_ProveedorOC');
        $this->dataOC['MontoOC'] = $this->input->post('input_MontoOC');        

        $this->datosVista['local']=$this->ModeloPrincipal_model->get_local('1');
        $this->datosVista['planesPago']=$this->PlanPago_model->get_all_planes_pago();    
               
    }
 
    public function index()
    {
        $this->load->helper('url');
 
        $this->load->view('header_view');                      
        $this->load->view('nav_view',$this->datosVista);                      
        $this->load->view('PlanPago_view',$this->datosVista);
    }
 
  
    public function agregar_planPago()
    {
    
       if ($this->form_validation->run() == FALSE) 
       {
            echo json_encode(validation_errors());
       } 
       else 
       {
            $insert = $this->PlanPago_model->agregar_planPago($this->data);
            echo json_encode(array("status" => TRUE));
       }  
        
    }

    public function ajax_update()
    {
        if ($this->form_validation->run() == FALSE) 
        {
            echo json_encode(validation_errors());
        } 
        else 
        {
            $this->PlanPago_model->actualizar_planPago(array('IdPlanPago' => $this->input->post('input_IdPlanPago')),$this->data);
            $this->PlanPago_model->actualizar_OC(array('NroOC' => $this->input->post('input_NroOC')),$this->dataOC);
            echo json_encode(array("status" => TRUE));
        }

    }


    public function editar_planPago($id)
    {
        $data = $this->PlanPago_model->get_by_id($id);
        $data->FechaEmisionOC = ($data->FechaEmisionOC == '0000-00-00') ? '' : date('d-m-Y', strtotime($data->FechaEmisionOC));
        $data->FechaPago = ($data->FechaPago == '0000-00-00') ? '' : date('d-m-Y', strtotime($data->FechaPago));
        echo json_encode($data);
    }

    public function buscar_oc($oc)
    {
        $data = $this->PlanPago_model->get_oc($oc);

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

 
    public function eliminar_planPago($id)
    {
        $this->PlanPago_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

}