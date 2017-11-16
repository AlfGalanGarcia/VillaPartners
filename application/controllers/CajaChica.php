<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CajaChica extends CI_Controller 
{
	//public $data = array();    
    public $datosVista = array();
    public $datosCajaChica = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModeloPrincipal_model');
        $this->load->model('CajaChica_model');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('input_IdDetalleCC', 'Número de documento', 'required|is_natural');
        $this->form_validation->set_rules('input_FechaEmision', 'Fecha de emisión', 'required');
        $this->form_validation->set_rules('input_DescripcionCC', 'Descripción', 'required');
        $this->form_validation->set_rules('input_Monto', 'Monto', 'required|decimal|greater_than[0]');
        $this->datosVista['observados']=$this->ModeloPrincipal_model->get_observados();

        //Campos formulario
        $this->data['IdDetalleCC'] = $this->input->post('input_IdDetalleCC');        
        $this->data['IdCajaChica'] = $this->input->post('input_IdCajaChica');
        $this->data['IdProveedor'] = $this->input->post('input_IdProveedor');
        $this->data['FechaEmision'] = date('Y-m-d', strtotime($this->input->post('input_FechaEmision')));
        $this->data['DescripcionCC'] = $this->input->post('input_DescripcionCC');
        $this->data['IdTipoDoc'] = $this->input->post('input_IdTipoDoc');
        $this->data['IdMoneda'] = $this->input->post('input_IdMoneda');
        $this->data['IdIgv'] = $this->input->post('input_IdIgv');
        if ($this->input->post('input_IdMoneda') == 1) {
            $this->data['Monto'] = $this->input->post('input_Monto');  
        }
        else
        {
            $this->data['Monto'] = ($this->input->post('input_Monto')*($this->ModeloPrincipal_model->get_tipoCambio()[0]->valorTC)); //TC 3.24    
        }
        

        $this->datosVista['detalleCajaChica']=$this->CajaChica_model->get_all_cajaChica(); 
        $this->datosVista['sumaMontosCC']=$this->CajaChica_model->get_all_montosCC(); 
        $this->datosVista['tipoDoc']=$this->ModeloPrincipal_model->get_tipoDoc();   
        $this->datosVista['montoCajaChica']=$this->ModeloPrincipal_model->get_montoCajaChica();   
        $this->datosVista['proveedor']=$this->ModeloPrincipal_model->get_proveedor();   
        $this->datosVista['moneda']=$this->ModeloPrincipal_model->get_moneda(); 
        $this->datosVista['igv']=$this->ModeloPrincipal_model->get_IGV(); 
        $this->datosVista['local']=$this->ModeloPrincipal_model->get_local('1');
        $this->datosVista['tc']=$this->ModeloPrincipal_model->get_tipoCambio();
        
    }

    public function index()
    {
        $this->load->helper('url');
 
        $this->load->view('header_view');                      
        $this->load->view('nav_view',$this->datosVista);                      
        $this->load->view('cajaChica_view',$this->datosVista);
    }

    public function registrar_documento()
    {
    
       if ($this->form_validation->run() == FALSE) 
       {
            echo json_encode(validation_errors());
       } 
       else 
       {
       		$this->CajaChica_model->registrar_documento($this->data);
       		echo json_encode(array("status" => TRUE));	       
       }  
    }

    public function editar_documento($id)
    {
        $data = $this->CajaChica_model->get_by_id($id);
        $data->FechaEmision = ($data->FechaEmision == '0000-00-00') ? '' : date('d-m-Y', strtotime($data->FechaEmision));
        echo json_encode($data);
    }

    public function ajax_update()
    {
        /*if ($this->form_validation->run() == FALSE) 
        {
            echo json_encode(validation_errors());
        } 
        else 
        {      */  	
            $this->CajaChica_model->actualizar_documento(array('IdDetalleCC' => $this->input->post('input_IdDetalleCC')), $this->data);
            echo json_encode(array("status" => TRUE));
        //}

    }

    public function eliminar_documento()
    {    	
        $this->CajaChica_model->delete_by_id($this->input->post('id'));
        echo json_encode(array("status" => TRUE));
    }
}