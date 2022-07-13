<?php

class TareasxDelegacion_model extends CI_Model{

  function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->model('tareas_model');
    $this->load->model('delegacion_model');
    $this->load->model('gerencia_model');
  }

  public function select_tareasxdelegacion_byID($id_delegacion,$id_tarea) {
    $results = $this->db->query('SELECT * FROM turnos_tareasxdelegacion WHERE idtarea = '.$id_tarea.' and iddelegacion='.$id_delegacion);
    foreach ($results->result() as $row)
    {
        $data['id_tarea'] = $row->idtarea;
        $data['id_delegacion']= $row->iddelegacion;
        $data['privacidad']= $row->privacidad;
        $data['hora_inicio_atencion'] = $row->hora_inicio_atencion;
        $data['hora_fin_atencion'] = $row->hora_fin_atencion;
        $data['tienepuestos'] = $row->tienepuestos;
        $data['fecha_limite'] = $row->fecha_limite;
    }
    return $data;
  }
  public function select_tareasxdelegacion_byDelegacion($id) {
      $tareaxdelegacion = array();
      $results = $this->db->query("SELECT * FROM turnos_tareasxdelegacion WHERE iddelegacion =".$id." AND privacidad != '-' ORDER BY iddelegacion");
      foreach ($results->result() as $row){
        $tarea = $this->tareas_model->select_tarea_byID($row->idtarea);
        $rowdata['id_tarea'] = $row->idtarea;
        $rowdata['id_delegacion']    = $this->delegacion_model->select_delegacion_byID($row->iddelegacion)['nom_delegacion'];
        $rowdata['privacidad'] = $row->privacidad;
        $rowdata['hora_inicio_atencion'] = $row->hora_inicio_atencion;
        $rowdata['hora_fin_atencion'] = $row->hora_fin_atencion;
        $rowdata['tienepuestos'] = $row->tienepuestos;
        $rowdata['fecha_limite'] = $row->fecha_limite;
        $rowdata['nombre_tarea'] = $tarea ['nombreTarea'];
        $rowdata['mensaje_tarea'] = $tarea ['mensaje'];
        $rowdata['resaltar_tarea'] = $tarea ['resaltar'];
        $data['fecha_limite'] = $row->fecha_limite;
        //parametros extras para agrupar
        $rowdata['id_gerencia'] = $tarea['id_gerencia'] ;
        $rowdata['nom_gerencia'] = $this->gerencia_model->select_gerencia_byID($tarea['id_gerencia'])['nom_gerencia'];
        $tareaxdelegacion[]        = $rowdata;
      }
      return $tareaxdelegacion;
  }

  public function select_tareasxdelegacion_ymas($iddelegacion,$idgerencia,$idtarea) {

    $results = $this->db->query('SELECT td.iddelegacion,t.id_gerencia, td.idtarea,td.privacidad,td.hora_inicio_atencion,td.hora_fin_atencion,
                                        td.fecha_limite,p.turnosmismohorario,p.intervalo
                                  FROM ipav.turnos_tareasxdelegacion as td
                                    INNER JOIN ipav.turnos_parametros as p
                                    INNER JOIN ipav.turnos_tarea as t
                                    on td.iddelegacion=p.id_delegacion and td.idtarea=t.id_tarea and t.id_gerencia=p.id_gerencia
                                  where td.iddelegacion='.$iddelegacion.' and t.id_gerencia='.$idgerencia.' and t.id_tarea='.$idtarea.';');
    foreach ($results->result() as $row)
    {
        $data['iddelegacion'] = $row->iddelegacion;
        $data['id_gerencia']= $row->id_gerencia;
        $data['idtarea']= $row->idtarea;
        $data['privacidad'] = $row->privacidad;
        $data['hora_inicio_atencion'] = $row->hora_inicio_atencion;
        $data['hora_fin_atencion'] = $row->hora_fin_atencion;
        $data['fecha_limite'] = $row->fecha_limite;
        $data['turnosmismohorario'] = $row->turnosmismohorario;
        $data['intervalo'] = $row->intervalo;
    }
    return $data;
  }
}
  ?>
