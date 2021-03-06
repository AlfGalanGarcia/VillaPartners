<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class CobrarCuenta_model extends CI_Model {
 
    var $tablaPedidoMesa = 'pedidomesa'; 
    var $tablaVenta = 'venta';   
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_pedidoMesa()
    {        
        $query=$this->db->query('
            SELECT pedidomesa.*, estado.*, empleado.*, CONCAT(empleado.Nombres," ",empleado.ApePaterno) as nombres,
            (SELECT empleado.Alias FROM empleado where empleado.IdEmpleado = pedidomesa.IdEmpleadoSesion) as aliasSesion 
            FROM pedidomesa
            INNER JOIN estado ON estado.IdEstado = pedidomesa.IdEstadoPedido 
            INNER JOIN empleado ON empleado.IdEmpleado = pedidomesa.IdEmpleado');
            return $query->result();
    }

    public function get_detalle_pedido($id)
    {
        $query=$this->db->query("
            SELECT pedidomesa.*, detallepedido.*, producto.*, estado.*, CONCAT(empleado.Nombres,' ',empleado.ApePaterno) as nombres,
            (SELECT empleado.Alias FROM empleado where empleado.IdEmpleado = pedidomesa.IdEmpleadoSesion) as aliasSesion 
            from pedidomesa
            INNER JOIN empleado ON empleado.IdEmpleado = pedidomesa.IdEmpleado
            INNER JOIN estado ON estado.IdEstado = pedidomesa.IdEstadoPedido
			INNER JOIN detallepedido ON detallepedido.IdPedido = pedidomesa.IdPedido
			INNER JOIN producto ON producto.IdProducto = detallepedido.IdProducto WHERE pedidomesa.IdPedido = '$id'");
            return $query->result();    	
    }

    public function cambiar_estado($id, $data)
    {
        $this->db->where('IdPedido', $id);
        $this->db->update($this->tablaPedidoMesa, $data);
        return $this->db->affected_rows();
    }

    public function pagar($data)
    {
    	$this->db->insert($this->tablaVenta, $data);
        return $this->db->insert_id();
    }
}    