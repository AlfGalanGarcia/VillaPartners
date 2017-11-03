<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginVilla extends CI_Controller {
	
	public $datosVista = array();   

    public function __construct()
    {
        parent::__construct();	
        $this->load->helper('form');	
		$this->load->helper('url');		
		$this->load->model('LoginVilla_model');
		$this->load->model('ModeloPrincipal_model');
		$this->load->model('PlanPago_model');

		$this->datosVista['local']=$this->ModeloPrincipal_model->get_local('1');
        $this->datosVista['planesPago']=$this->PlanPago_model->get_all_planes_pago(); 
        $this->datosVista['mensaje'] = ''; 
    }
    
	public function index()
	{
		
		$this->load->view('loginVilla_view',$this->datosVista);
	}
	
	public function acceder()
	{
		$user = $this->input->post('user');
		$password = md5($this->input->post('password'));
		
		$result = $this->LoginVilla_model->acceder($user, $password);
		if ($result	== TRUE)
		{
			$this->load->view('header_view');                      
        	$this->load->view('nav_view',$this->datosVista);                      
        	$this->load->view('PlanPago_view',$this->datosVista);
		}
		else
		{
			$this->datosVista['mensaje']  = "Usuario o clave incorrectos";
			$this->load->view('loginVilla_view',$this->datosVista);
		}
	}

}
