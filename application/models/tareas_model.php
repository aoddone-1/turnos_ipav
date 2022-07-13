<?php

class Tareas_model extends CI_Model{

  function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->model('gerencia_model');
  }

  public function select_tarea_byID($id) {
    $results = $this->db->query('SELECT * FROM turnos_tarea WHERE id_tarea = '.$id);
    foreach ($results->result() as $row)
    {
        $data['id_tarea'] = $row->id_tarea;
        $data['id_gerencia']    = $row->id_gerencia;
        $data['nombreTarea']       = $row->nombreTarea;
        $data['resaltar']       = $row->resaltar;
        $data['mensaje']       = $row->mensaje;
    }
    return $data;
  }

  public function select_tareas() {
    $tarea = array();
    $results = $this->db->query('SELECT * FROM turnos_tarea ORDER BY nombreTarea');
    foreach ($results->result() as $row){
      $rowdata['id_tarea'] = $row->id_tarea;
      $rowdata['id_gerencia']    = $this->gerencia_model->select_gerencia_byID($row->id_gerencia)['nom_gerencia'] ;
      $rowdata['nombreTarea']    = $row->nombreTarea;
      $tarea[]        = $rowdata;
    }
    return $tarea;
  }
}
  ?>
