<?php

class Empleado_model extends CI_Model{

  function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function empleadoExiste($cuit){
    $this->db->where('cuit',$cuit);
    $q=$this->db->get('turnos_empleado');


    if($q->num_rows()>0){
      return TRUE;
    }else{
      return FALSE;
    }
  }
}
  ?>
