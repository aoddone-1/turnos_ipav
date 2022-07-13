<?php

class DiasNoLaborables_model extends CI_Model{

  function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function select_diasnolaborables() {
    $diasnolaborables = array();
    $results = $this->db->query('SELECT * FROM turnos_diasnolaborables');
    foreach ($results->result() as $row){
      $rowdata['fecha'] = $row->fecha;
      $rowdata['marca']    = $row->marca;
      $diasnolaborables[]        = $rowdata;
    }
    return $diasnolaborables;
  }

  public function esdianolaboral($fecha){
    $this->db->where('fecha',$fecha);
    $q=$this->db->get('turnos_diasnolaborables');


    if($q->num_rows()>0){
      return TRUE;
    }else{
      return FALSE;
    }
  }
}
  ?>
