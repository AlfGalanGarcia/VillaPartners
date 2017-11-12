<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class ValeProvisional extends CI_Controller {

    public $data = array();    
    public $datosVista = array();
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ValeProvisional_model');
        $this->load->model('ModeloPrincipal_model');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('input_motivo', 'Motivo', 'required');
        $this->form_validation->set_rules('input_montoSolicitado', 'Monto solicitado', 'required|decimal');

        //Campos formulario
        $this->data['FechaCreacion'] = date('Y-m-d', strtotime($this->input->post('input_FechaCreacion')));
        $this->data['Motivo'] = $this->input->post('input_motivo');
        $this->data['MontoSolicitado'] = $this->input->post('input_montoSolicitado');
        $this->data['IdEmpleado'] = $this->input->post('input_empleado');
        $this->data['IdLocal'] = $this->input->post('input_IdLocal');
        $this->data['IdEstado'] = $this->input->post('input_IdEstado');

         //datos
        $this->datosVista['valeProvisional']=$this->ValeProvisional_model->get_all_vale_provisional();
        $this->datosVista['empleado']=$this->ModeloPrincipal_model->get_empleado();   
        $this->datosVista['local']=$this->ModeloPrincipal_model->get_local();   
        $this->datosVista['observados']=$this->ModeloPrincipal_model->get_observados();      

    }
 
    public function index()
    {
        $this->load->helper('url');
        $this->load->view('header_view');                      
        $this->load->view('nav_view',$this->datosVista);                      
        $this->load->view('ValeProvisional_view',$this->datosVista);
    }
 
    public function agregar_vale_provisional()
    {
    
       if ($this->form_validation->run() == FALSE) 
       {
            echo json_encode(validation_errors());
       } 
       else 
       {
            $this->ValeProvisional_model->agregar_vale_provisional($this->data);
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
            $this->ValeProvisional_model->actualizar_vale_provisional(array('IdVale' => $this->input->post('input_IdVale')), $this->data);
            echo json_encode(array("status" => TRUE));
        }

    }

    public function editar_valeProvisional($id)
    {
        $data = $this->ValeProvisional_model->get_by_id($id);
        //$hoy = date('d-m-Y');
        //$data->FechaCreacion = ($data->FechaCreacion == '0000-00-00') ? '' : date('d-m-Y', strtotime($data->FechaCreacion));
        echo json_encode($data);
    }
 
    public function eliminar_valeProvisional($id)
    {
        $this->ValeProvisional_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

 
}