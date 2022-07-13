<?php

class Parametros_model extends CI_Model{

  function __construct(){
    parent::__construct();
    $this->load->database();
  }


  public function select_parametros_byIDs($iddelegacion,$idgerencia) {
//Select Query
    $results = $this->db->query('SELECT * FROM turnos_parametros WHERE id_delegacion ='. $iddelegacion .' and id_gerencia='. $idgerencia);
    foreach ($results->result() as $row)
    {
        $data['id_parametro'] = $row->id_parametro;
        $data['id_delegacion']    = $row->id_delegacion;
        $data['id_gerencia']       = $row->id_gerencia;
        $data['turnosmismohorario']       = $row->turnosmismohorario;
        $data['cantDiarios']       = $row->cantDiarios;
        $data['intervalo']       = $row->intervalo;
    }
    return $data;
  }
}
?>
