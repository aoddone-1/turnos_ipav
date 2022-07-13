<?php

class Delegacion_model extends CI_Model{

  function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function select_delegacion_byID($id) {
    $results = $this->db->query('SELECT * FROM ipav_delegacion WHERE id_delegacion = '.$id);
    foreach ($results->result() as $row)
    {
        $data['id_delegacion'] = $row->id_delegacion;
        $data['nom_delegacion']    = $row->nom_delegacion;
        $data['direccion']    = $row->direccion;
        $data['mapa']    = $row->mapa;
    }
    return $data;
  }

  public function select_delegaciones() {
    $delegacion = array();
    $results = $this->db->query('SELECT * FROM ipav_delegacion');
    foreach ($results->result() as $row){
      $rowdata['id_delegacion'] = $row->id_delegacion;
      $rowdata['nom_delegacion']    = $row->nom_delegacion;
      $rowdata['direccion']    = $row->direccion;
      $rowdata['mapa']    = $row->mapa;
      $delegacion[]        = $rowdata;
    }
    return $delegacion;
  }
}
  ?>
