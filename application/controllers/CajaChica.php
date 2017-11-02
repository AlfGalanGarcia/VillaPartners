<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CajaChica extends CI_Controller 
{
	//public $data = array();    
    public $datosVista = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModeloPrincipal_model');

        $this->datosVista['local']=$this->ModeloPrincipal_model->get_local('1');
        //$this->datosVista['planesPago']=$this->PlanPago_model->get_all_planes_pago();    
        $this->datosVista['empleadoLogin']=$this->ModeloPrincipal_model->get_empleadoLogin($this->input->post('user')); 
    }

    public function index()
    {
        $this->load->helper('url');
 
        $this->load->view('header_view');                      
        $this->load->view('nav_view',$this->datosVista);                      
        $this->load->view('cajaChica_view',$this->datosVista);
    }
}