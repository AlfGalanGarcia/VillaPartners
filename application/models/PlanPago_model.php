<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class PlanPago_model extends CI_Model {
 
    var $tablaPlanPago = 'planpago';
    var $tablaOC = 'ordencompra';
    var $tablalocal = 'local';
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
  
    public function get_all_planes_pago()
    {
        $this->db->from($this->tablaPlanPago);
        $query=$this->db->query('
            SELECT planpago.*, ordencompra.* FROM planpago 
            INNER JOIN ordencompra ON planpago.NroOC = ordencompra.NroOC
            ORDER BY FechaPago DESC');
        return $query->result();
    }
 
    public function get_by_id($id)
    {
        //$this->db->from($this->tablaPlanPago);
        $this->db->where('planpago.IdPlanPago',$id);
        $this->db->join('ordencompra', 'planpago.NroOC = ordencompra.NroOC');
        $query = $this->db->get();
 
        return $query->row();
    }

    public function get_oc($oc)
    {
        $this->db->from($this->tablaPlanPago);
        $this->db->where('ordencompra.NroOC',$oc);
        $query=$this->db->query('
            SELECT ordencompra.* FROM ordencompra 
            INNER JOIN planpago ON ordencompra.NroOC = planpago.NroOC');
        return $query->row();
    }

    public function agregar_planPago($data)
    {
        
        $this->db->insert($this->tablaPlanPago, $data);
        return $this->db->insert_id();
    }
 
    public function actualizar_planPago($where, $data)
    {
        $this->db->update($this->tablaPlanPago, $data, $where);
        return $this->db->affected_rows();
    }

    public function actualizar_OC($where, $data)
    {
        $this->db->update($this->tablaOC, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where('IdPlanPago', $id);
        $this->db->delete($this->tablaPlanPago);
    }

}