<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AbrirCaja extends CI_Controller 
{
	

    public function __construct()
    {
    	parent::__construct();
    	$this->load->model('ModeloPrincipal_model');
    	$this->load->model('Caja_model');
        $this->datosVista['local']=$this->ModeloPrincipal_model->get_local('1');       
        $this->datosVista['caja']=$this->Caja_model->get_caja();       
    }

    public function index()
    {
        $this->load->helper('url');
 
        $this->load->view('header_view');                      
        $this->load->view('nav_view',$this->datosVista);                      
        $this->load->view('abrirCaja_view',$this->datosVista);
    }

    public function cerrar_caja($id)
    {

        $this->Caja_model->cerrar_caja($id,array('IdEstadoCaja' => '5'));
        echo json_encode(array("status" => TRUE));

    }
}
