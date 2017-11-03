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

        //Campos formulario
        $this->data['IdCajaChica'] = $this->input->post('input_IdCajaChica');
        $this->data['IdDetalleCC'] = $this->input->post('input_IdDetalleCC');
        $this->data['IdProveedor'] = $this->input->post('input_IdProveedor');
        $this->data['FechaEmision'] = date('Y-m-d', strtotime($this->input->post('input_FechaEmision')));
        $this->data['DescripcionCC'] = $this->input->post('input_DescripcionCC');
        $this->data['IdTipoDoc'] = $this->input->post('input_IdTipoDoc');
        $this->data['IdMoneda'] = $this->input->post('input_IdMoneda');
        $this->data['IdIgv'] = $this->input->post('input_IdIgv');
        $this->data['Monto'] = $this->input->post('input_Monto')*1.18;
        
        $this->dataCajaChica['MontoCC'] = $this->input->post('input_MontoCC')-$this->input->post('input_Monto')*1.18;


        $this->datosVista['detalleCajaChica']=$this->CajaChica_model->get_all_cajaChica(); 
        $this->datosVista['tipoDoc']=$this->ModeloPrincipal_model->get_tipoDoc();   
        $this->datosVista['montoCajaChica']=$this->ModeloPrincipal_model->get_montoCajaChica();   
        $this->datosVista['proveedor']=$this->ModeloPrincipal_model->get_proveedor();   
        $this->datosVista['moneda']=$this->ModeloPrincipal_model->get_moneda(); 
        $this->datosVista['igv']=$this->ModeloPrincipal_model->get_IGV(); 
        $this->datosVista['local']=$this->ModeloPrincipal_model->get_local('1');        
        
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
    
       /*if ($this->form_validation->run() == FALSE) 
       {
            echo json_encode(validation_errors());
       } 
       else 
       {*/	
       		$this->CajaChica_model->registrar_documento($this->data);
       		echo json_encode(array("status" => TRUE));	
       		$this->CajaChica_model->actualizar_cajachica(array('IdCajaChica' => '1'),$this->dataCajaChica);
            
       //}  
    }

    public function eliminar_documento($id)
    {
        $this->CajaChica_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}