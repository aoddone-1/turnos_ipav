<?php

class Localidad_model extends CI_Model{

  function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function select_localidades_byProvincia($id_provincia) {
    $localidad = array();
    $results = $this->db->query('SELECT * FROM ipav_localidades WHERE idpro_loc='.$id_provincia.' order by nombre_loc');
    foreach ($results->result() as $row){
      $rowdata['id_loc'] = $row->id_loc;
      $rowdata['nombre_loc']    = $row->nombre_loc;
      $localidad[]        = $rowdata;
    }
    return $localidad;
  }

  public function select_localidades_byID($id_localidad) {
    $results = $this->db->query('SELECT * FROM ipav_localidades WHERE id_loc = '.$id_localidad);
    foreach ($results->result() as $row)
    {
        $data['id_loc'] = $row->id_loc;
        $data['nombre_loc']    = $row->nombre_loc;
        $data['descrip_loc'] = $row->descrip_loc;
        $data['idpro_loc'] = $row->idpro_loc;
    }
    return $data;
  }
}
  ?>
