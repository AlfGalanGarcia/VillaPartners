<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class CobrarCuenta_model extends CI_Model {
 
    var $tablaPedidoMesa = 'pedidomesa';    
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_pedidoMesa()
    {
        $this->db->from($this->tablaPedidoMesa);
        $query=$this->db->query('
            SELECT pedidomesa.*, estado.*, empleado.*, CONCAT(empleado.Nombres," ",empleado.ApePaterno) as nombres,
            (SELECT empleado.Alias FROM empleado where empleado.IdEmpleado = pedidomesa.IdEmpleadoSesion) as aliasSesion 
            FROM pedidomesa
            INNER JOIN estado ON estado.IdEstado = pedidomesa.IdEstadoPedido 
            INNER JOIN empleado ON empleado.IdEmpleado = pedidomesa.IdEmpleado 
            ORDER BY IdPedido ASC');
            return $query->result();
    }

    /*public function get_all_pedidoMesa_id($id)
    {
        $this->db->from($this->tablaPedidoMesa);
        $this->db->where('IdPedido', $id);
        $query=$this->db->query('
            SELECT pedidomesa.*, estado.*, empleado.*, CONCAT(empleado.Nombres," ",empleado.ApePaterno) as nombres,
            (SELECT empleado.Alias FROM empleado where empleado.IdEmpleado = pedidomesa.IdEmpleadoSesion) as aliasSesion 
            FROM pedidomesa
            INNER JOIN estado ON estado.IdEstado = pedidomesa.IdEstadoPedido 
            INNER JOIN empleado ON empleado.IdEmpleado = pedidomesa.IdEmpleado 
            ORDER BY IdPedido ASC');
            return $query->result();
    }*/
    public function get_detalle_pedido($id)
    {
        //$this->db->from($this->tablaPedidoMesa);
        //$this->db->where('IdPedido', $id);
        $query=$this->db->query("
            SELECT pedidomesa.*, detallepedido.*, producto.*,
            (SELECT empleado.Alias FROM empleado where empleado.IdEmpleado = pedidomesa.IdEmpleadoSesion) as aliasSesion 
            from pedidomesa
			INNER JOIN detallepedido ON detallepedido.IdPedido = pedidomesa.IdPedido
			INNER JOIN producto ON producto.IdProducto = detallepedido.IdProducto WHERE pedidomesa.IdPedido = '$id'");
            return $query->result();
    	
    }

    public function precuenta($id, $data)
    {
        $this->db->where('IdPedido', $id);
        $this->db->update($this->tablaPedidoMesa, $data);
        return $this->db->affected_rows();
    }
}    