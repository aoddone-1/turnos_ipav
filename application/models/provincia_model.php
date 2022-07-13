<?php

class Provincia_model extends CI_Model{

  function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function select_provincias() {
    $provincia = array();
    $results = $this->db->query('SELECT * FROM ipav_provincias order by nombre_provincia');
    foreach ($results->result() as $row){
      $rowdata['idprovincias'] = $row->idprovincias;
      $rowdata['nombre_provincia']    = $row->nombre_provincia;
      $provincia[]        = $rowdata;
    }
    return $provincia;
  }
}
  ?>
