<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class AprobarPagos_model extends CI_Model {
 
    var $tablaArchivoBanco = 'archivobanco';
    var $tablaArchivoPagos = 'archivoPagos';
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_archivoBanco()
    {
        $this->db->from($this->tablaArchivoBanco);
        $query=$this->db->query('
            SELECT archivobanco.*, banco.*, archivoPagos.*, proveedor.* FROM archivobanco 
            INNER JOIN archivoPagos ON archivoPagos.IdArchivoPagos = archivobanco.IdArchivoPagos
            INNER JOIN banco ON banco.IdBanco = archivobanco.IdBanco
            INNER JOIN proveedor ON proveedor.IdProveedor = archivobanco.IdProveedor            
            ORDER BY FechaPago DESC');
        //if($query->num_rows() > 0){
            return $query->result();
        /*} else {
            return $query->result_array();
        }*/
    }

    public function aprobar_pago($id, $data)
    {
        $this->db->where('IdArchivoPagos', $id);
        $this->db->update($this->tablaArchivoPagos, $data);
        return $this->db->affected_rows();
    }

    public function get_datos_aprobar($id)
    {        
        //$this->db->where('tempoc.IdArchivoPagos', $id);
        $query=$this->db->query('
            SELECT tempoc.*, proveedor.*, proveedorbanco.* from tempoc
			INNER JOIN proveedor on proveedor.IdProveedor = tempoc.ProveedorOC
			INNER join proveedorbanco on proveedor.IdProveedor = proveedorbanco.IdProveedor
            ORDER BY FechaEmisionOC DESC');        
        return $query->result();
    }
    
    public function generar_tabla_banco($post)
    {
    	$query=$this->db->query('
            SELECT tempoc.*, proveedor.*, proveedorbanco.* from tempoc
			INNER JOIN proveedor on proveedor.IdProveedor = tempoc.ProveedorOC
			INNER join proveedorbanco on proveedor.IdProveedor = proveedorbanco.IdProveedor
            ORDER BY FechaEmisionOC DESC');
    	
        $max = $query->num_rows();
        $filas = range(1, $max);
    	$data = array();
        foreach ($filas as $n) {            
            $data[] = array(
                'IdBanco'   			=> $post["input_IdBanco{$n}"],
                'NroOC' 				=> $post["input_NroOC{$n}"],
                'IdProveedor' 			=> $post["input_IdProveedor{$n}"],
                'NroCtaCteDestino' 		=> $post["input_NroCtaCteDestino{$n}"],
                'MontoPago' 			=> $post["input_MontoOC{$n}"],
                'NroCtaCteOrigen' 		=> $post["input_NroCtaCteOrigen"],
                'IdArchivoPagos' 		=> $post["input_IdArchivoPagos"],
                'FechaPago' 			=> date('Y-m-d', strtotime($post["input_FechaPago"])),
                
            );
        }
    	$this->db->insert_batch($this->tablaArchivoBanco, $data);
    }

    public function rechazar_pago($where,$data)
    {
        $this->db->update($this->tablaArchivoPagos, $data, $where);
        return $this->db->affected_rows();
    }
}
