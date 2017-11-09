<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AbrirCaja extends CI_Controller 
{
	

    public function __construct()
    {
    	parent::__construct();
    	$this->load->model('ModeloPrincipal_model');
    	$this->load->helper('form');
    	$this->load->model('Caja_model');
        $this->load->library('form_validation');
        $this->datosVista['local']=$this->ModeloPrincipal_model->get_local('1');       
        $this->datosVista['caja']=$this->Caja_model->get_caja();    
        $this->datosVista['mensaje'] = ''; 
        $this->datosVista['mensajeError'] = '';    

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('montoSoles', 'Monto en soles', 'required|decimal');
        $this->form_validation->set_rules('montoDolares', 'Monto en dólares', 'required|is_natural');
    }

    public function index()
    {
       if (($this->datosVista['caja'][0]->IdEstadoCaja) == 5) 
        {
            $this->load->helper('url');
            $this->load->view('header_view');                      
            $this->load->view('nav_view',$this->datosVista);
            $this->load->view('abrirCaja_view',$this->datosVista);                      
        }                      
        else
        {
            if (($this->datosVista['caja'][0]->IdEmpleadoCaja) == $this->session->userdata('id')) 
            {
                if (($this->datosVista['caja'][0]->IdEstadoCaja) == 4) {
                    $this->load->helper('url');
                    $this->load->view('header_view');                      
                    $this->load->view('nav_view',$this->datosVista);                              
                    $this->load->view('cuadrarCaja_view',$this->datosVista);
                }
                else
                {
                    $this->load->view('abrirCaja_view');                              
                }
                
            }
            else
            {
                $this->datosVista['mensajeError']  = "<center>El usuario ".$this->datosVista['caja'][0]->Alias." está abriendo la caja en este momento. No se puede realizar la operación</center>";
                $this->load->view('header_view');                      
                $this->load->view('nav_view',$this->datosVista);   
                $this->load->view('abrirCaja_view', $this->datosVista); 
            }
        }
    }

    public function cuadrar_caja()
    {
        $this->load->helper('url');
        $this->load->view('header_view');                      
        $this->load->view('nav_view',$this->datosVista);                              
        $this->load->view('cuadrarCaja_view',$this->datosVista);
    }    

	public function abrir_caja()
    {
		$this->data['IdEstadoCaja'] = '4';
        $this->data['montoSoles'] = $this->input->post('montoSoles');
        $this->data['montoDolares'] = $this->input->post('montoDolares');
        $this->data['IdEmpleadoCaja'] = $this->input->post('userId');

        if ($this->form_validation->run() == FALSE) 
        {
            echo json_encode(validation_errors());
        } 
        else 
        {
            $this->Caja_model->abrir_caja(array('IdCaja' => '1'), $this->data);
            echo json_encode(array("status" => TRUE));
        }    
    }

    public function cerrar_caja($id)
    {
        $this->Caja_model->cerrar_caja($id,array('IdEstadoCaja' => '5'));
        echo json_encode(array("status" => TRUE));
    }
}
