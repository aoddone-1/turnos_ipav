<?php

class Turnos_model extends CI_Model{

  function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->model('tareas_model');
    $this->load->model('tareasxdelegacion_model');
    $this->load->model('gerencia_model');
    $this->load->model('delegacion_model');
  }

  public function usuarioExiste($cuit){
    $this->db->where('cuit',$cuit);
    $q=$this->db->get('usuario');


    if($q->num_rows()>0){
      return TRUE;
    }else{
      return FALSE;
    }
  }
  public function select_cant_turnos_pendientes($id_delegacion,$id_tarea){
    $results = $this->db->query('SELECT count(*) as cantidad FROM turnos where id_tarea ='.$id_tarea.' and (fecha_turno is null and hora_turno is null) and id_delegacion='.$id_delegacion);
    foreach ($results->result() as $row)
    {
      $data['cantidad'] = $row->cantidad;
    }
    return $data;
  }

  public function select_turno_byID($id) {
    $results = $this->db->query('SELECT * FROM turnos WHERE id_turno = '.$id);
    foreach ($results->result() as $row)
    {
        $data['id_turno'] = $row->id_turno;
        $data['cuit']    = $row->cuit;
        $data['puesto']    = $row->puesto;
        $usuario = $this->usuario_model->select_usuario_byCuit($row->cuit);
        $data['nombre_apellido'] = $usuario['apellido'].', '.$usuario['nombre'];
        $data['fecha_turno']       = $row->fecha_turno;
        $data['hora_turno']       = $row->hora_turno;
        $data['id_tarea']       = $this->tareas_model->select_tarea_byID($row->id_tarea)['nombreTarea'];
        $data['id_gerencia']       =  $this->gerencia_model->select_gerencia_byID($row->id_gerencia)['nom_gerencia'] ;
        $data['estado_turno']       = $row->estado_turno;
        $data['usuariocuit_inicioAtencion']       = $row->usuariocuit_inicioAtencion;
        $data['fechaHora_inicioAtencion']       = $row->fechaHora_inicioAtencion;
        $data['usuariocuit_finAtencion']       = $row->usuariocuit_finAtencion;
        $data['fechaHora_finAtencion']       = $row->fechaHora_finAtencion;
        $data['observacion']       = $row->observacion;
        $data['id_delegacion']       = $this->delegacion_model->select_delegacion_byID($row->id_delegacion)['nom_delegacion'] ;
        $data['fecha_hora_registro']       = $row->fecha_hora_registro;
    }
    return $data;
  }

  public function insert_turno($cuit,$fecha_turno,$hora_turno, $id_tarea,$id_gerencia,$id_delegacion,$observacion,$puesto) {

      $save = array(
         'cuit' => $cuit,
         'puesto' => $puesto,
         'fecha_turno' => $fecha_turno,
         'hora_turno' => $hora_turno,
         'id_tarea' => $id_tarea,
         'id_gerencia' => $id_gerencia,
         'id_delegacion' => $id_delegacion,
          'observacion' =>$observacion);


      $getResults=$this->db->insert('turnos', $save);
      $results = $this->db->query('SELECT LAST_INSERT_ID() as id_turno;');

      foreach ($results->result() as $row)
      {
          $id_turno = $row->id_turno;
      }

      if ($getResults == FALSE) {
           return FALSE;
      } else {
           return $id_turno;
      }
  }

  public function cambiar_estadoturno($estado, $id) {
//Update Query
      $save = array(
         'estado' => $estado);

      $this->db->where('id_turno', $id);
      $getResults=$this->db->update('turnos', $save);

      if ($getResults == FALSE) {
          return FALSE;
      } else {
          return TRUE;
      }
  }

  public function cambiar_estadoandobs($estado, $observacion, $id) {
//Update Query

      $save = array(
          'estado_turno' => $estado,
        'observacion'=>$observacion);

        $this->db->where('id_turno', $id);
        $getResults=$this->db->update('turnos', $save);
        if ($getResults == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }

  }

  public function select_turno_byPersonaEstado($estado,$cuit) {
    $turnos = array();
    $results = $this->db->where("estado_turno", $estado);
    $results = $this->db->where("cuit", $cuit);
    $results = $this->db->get('turnos');

    foreach ($results->result() as $row)
    {

        $rowdata['id_turno']     = $row->id_turno;
        $rowdata['cuit']     = $row->cuit;
        $rowdata['fecha_turno'] = $row->fecha_turno;
        $rowdata['hora_turno'] = $row->hora_turno;
        $rowdata['id_tarea'] =  $this->tareas_model->select_tarea_byID($row->id_tarea)['nombreTarea'];
        $rowdata['id_gerencia'] = $this->gerencia_model->select_gerencia_byID($row->id_gerencia)['nom_gerencia'] ;
        $rowdata['estado_turno'] = $row->estado_turno;
        $rowdata['usuariocuit_inicioAtencion'] = $row->usuariocuit_inicioAtencion;
        $rowdata['fechaHora_inicioAtencion'] = $row->fechaHora_inicioAtencion;
        $rowdata['usuariocuit_finAtencion'] = $row->usuariocuit_finAtencion;
        $rowdata['fechaHora_finAtencion'] = $row->fechaHora_finAtencion;
        $rowdata['observacion'] = $row->observacion;
        $rowdata['puesto'] = $row->puesto;
        $rowdata['id_delegacion'] = $this->delegacion_model->select_delegacion_byID($row->id_delegacion)['nom_delegacion'] ;
        $turnos[]        = $rowdata;
    }
    return $turnos;
  }

  public function select_turno_byhistorial($cuit) {
    $turnos = array();
    $results = $this->db->query("SELECT * FROM turnos WHERE cuit=$cuit and (estado_turno!='EN ESPERA') ORDER BY fecha_turno DESC, hora_turno DESC");


    foreach ($results->result() as $row)
    {
      $rowdata['id_turno']     = $row->id_turno;
      $rowdata['cuit']     = $row->cuit;
      $rowdata['fecha_turno'] = $row->fecha_turno;
      $rowdata['hora_turno'] = $row->hora_turno;
      $rowdata['id_tarea'] =  $this->tareas_model->select_tarea_byID($row->id_tarea)['nombreTarea'];
      $rowdata['id_gerencia'] = $this->gerencia_model->select_gerencia_byID($row->id_gerencia)['nom_gerencia'] ;
      $rowdata['estado_turno'] = $row->estado_turno;
      $rowdata['usuariocuit_inicioAtencion'] = $row->usuariocuit_inicioAtencion;
      $rowdata['fechaHora_inicioAtencion'] = $row->fechaHora_inicioAtencion;
      $rowdata['usuariocuit_finAtencion'] = $row->usuariocuit_finAtencion;
      $rowdata['fechaHora_finAtencion'] = $row->fechaHora_finAtencion;
      $rowdata['observacion'] = $row->observacion;
      $rowdata['id_delegacion'] = $this->delegacion_model->select_delegacion_byID($row->id_delegacion)['nom_delegacion'] ;
      $turnos[]        = $rowdata;
    }
    return $turnos;
  }

  public function select_turno_byFHDG($fecha,$hora,$delegacion,$gerencia) {
//Select Query
    $turnos = array();
    $results = $this->db->query("SELECT * FROM turnos WHERE fecha_turno = '$fecha' and hora_turno='$hora' and id_delegacion=$delegacion and id_gerencia=$gerencia and estado_turno <> 'CANCELADO'");
    foreach ($results->result() as $row){
      $rowdata['id_turno']     = $row->id_turno;
      $rowdata['cuit']     = $row->cuit;
      $rowdata['fecha_turno'] = $row->fecha_turno;
      $rowdata['hora_turno'] = $row->hora_turno;
      $rowdata['id_tarea'] =  $this->tareas_model->select_tarea_byID($row->id_tarea)['nombreTarea'];
      $rowdata['id_gerencia'] = $this->gerencia_model->select_gerencia_byID($row->id_gerencia)['nom_gerencia'] ;
      $rowdata['estado_turno'] = $row->estado_turno;
      $rowdata['usuariocuit_inicioAtencion'] = $row->usuariocuit_inicioAtencion;
      $rowdata['fechaHora_inicioAtencion'] = $row->fechaHora_inicioAtencion;
      $rowdata['usuariocuit_finAtencion'] = $row->usuariocuit_finAtencion;
      $rowdata['fechaHora_finAtencion'] = $row->fechaHora_finAtencion;
      $rowdata['observacion'] = $row->observacion;
      $rowdata['id_delegacion'] = $this->delegacion_model->select_delegacion_byID($row->id_delegacion)['nom_delegacion'] ;
      $turnos[]        = $rowdata;
    }
    return $turnos;
  }


  public function select_turno_byFechaHora($cuit,$fecha,$hora) {
//Select Query
    $turnos = array();
    if($fecha!=null && $hora!=null){
      $results = $this->db->query("SELECT * FROM turnos WHERE cuit=$cuit and fecha_turno = '$fecha' and hora_turno='$hora' and estado_turno='EN ESPERA'");
    }else{
      $results = $this->db->query("SELECT * FROM turnos WHERE cuit=$cuit and fecha_turno is null and hora_turno is null and estado_turno='EN ESPERA'");
    }

    foreach ($results->result() as $row){
      $rowdata['id_turno']     = $row->id_turno;
      $rowdata['cuit']     = $row->cuit;
      $rowdata['fecha_turno'] = $row->fecha_turno;
      $rowdata['hora_turno'] = $row->hora_turno;
      $rowdata['id_tarea'] =  $this->tareas_model->select_tarea_byID($row->id_tarea)['nombreTarea'];
      $rowdata['id_gerencia'] = $this->gerencia_model->select_gerencia_byID($row->id_gerencia)['nom_gerencia'] ;
      $rowdata['estado_turno'] = $row->estado_turno;
      $rowdata['usuariocuit_inicioAtencion'] = $row->usuariocuit_inicioAtencion;
      $rowdata['fechaHora_inicioAtencion'] = $row->fechaHora_inicioAtencion;
      $rowdata['usuariocuit_finAtencion'] = $row->usuariocuit_finAtencion;
      $rowdata['fechaHora_finAtencion'] = $row->fechaHora_finAtencion;
      $rowdata['observacion'] = $row->observacion;
      $rowdata['id_delegacion'] = $this->delegacion_model->select_delegacion_byID($row->id_delegacion)['nom_delegacion'] ;
      $turnos[]        = $rowdata;
    }
    return $turnos;
  }

  public function select_turno_byGerenciayDelegacion($cuit,$id_gerencia,$id_delegacion) {
//Select Query
    $turnos = array();
    $results = $this->db->query("SELECT * FROM turnos WHERE cuit=$cuit and id_gerencia= $id_gerencia and estado_turno='EN ESPERA' and id_delegacion=$id_delegacion and fecha_turno>=now()");
    foreach ($results->result() as $row){
      $rowdata['id_turno']     = $row->id_turno;
      $rowdata['cuit']     = $row->cuit;
      $rowdata['fecha_turno'] = $row->fecha_turno;
      $rowdata['hora_turno'] = $row->hora_turno;
      $rowdata['id_tarea'] =  $this->tareas_model->select_tarea_byID($row->id_tarea)['nombreTarea'];
      $rowdata['id_gerencia'] = $this->gerencia_model->select_gerencia_byID($row->id_gerencia)['nom_gerencia'] ;
      $rowdata['estado_turno'] = $row->estado_turno;
      $rowdata['usuariocuit_inicioAtencion'] = $row->usuariocuit_inicioAtencion;
      $rowdata['fechaHora_inicioAtencion'] = $row->fechaHora_inicioAtencion;
      $rowdata['usuariocuit_finAtencion'] = $row->usuariocuit_finAtencion;
      $rowdata['fechaHora_finAtencion'] = $row->fechaHora_finAtencion;
      $rowdata['observacion'] = $row->observacion;
      $rowdata['id_delegacion'] = $this->delegacion_model->select_delegacion_byID($row->id_delegacion)['nom_delegacion'] ;
      $turnos[]        = $rowdata;
    }
    return $turnos;
  }

  public function select_turno_byTarea($cuit,$id_tarea) {
//Select Query
    $turnos = array();
    $results = $this->db->query("SELECT * FROM turnos WHERE cuit=$cuit and id_tarea = $id_tarea and estado_turno='EN ESPERA'");
    foreach ($results->result() as $row){
      $rowdata['id_turno']     = $row->id_turno;
      $rowdata['cuit']     = $row->cuit;
      $rowdata['fecha_turno'] = $row->fecha_turno;
      $rowdata['hora_turno'] = $row->hora_turno;
      $rowdata['id_tarea'] =  $this->tareas_model->select_tarea_byID($row->id_tarea)['nombreTarea'];
      $rowdata['id_gerencia'] = $this->gerencia_model->select_gerencia_byID($row->id_gerencia)['nom_gerencia'] ;
      $rowdata['estado_turno'] = $row->estado_turno;
      $rowdata['usuariocuit_inicioAtencion'] = $row->usuariocuit_inicioAtencion;
      $rowdata['fechaHora_inicioAtencion'] = $row->fechaHora_inicioAtencion;
      $rowdata['usuariocuit_finAtencion'] = $row->usuariocuit_finAtencion;
      $rowdata['fechaHora_finAtencion'] = $row->fechaHora_finAtencion;
      $rowdata['observacion'] = $row->observacion;
      $rowdata['id_delegacion'] = $this->delegacion_model->select_delegacion_byID($row->id_delegacion)['nom_delegacion'] ;
      $turnos[]        = $rowdata;
    }
    return $turnos;
  }

  public function select_turno_byreserva($fecha, $hora, $delegacion, $id_tarea, $gerencia){
    $turnos = array();
    $results = $this->db->query("SELECT * FROM turnos WHERE fecha_turno = '$fecha' and hora_turno='$hora' and id_delegacion=$delegacion and id_gerencia=$gerencia and id_tarea=$id_tarea and estado_turno = 'EN ESPERA'");
    foreach ($results->result() as $row){
      $rowdata['id_turno']     = $row->id_turno;
      $rowdata['cuit']     = $row->cuit;
      $rowdata['fecha_turno'] = $row->fecha_turno;
      $rowdata['hora_turno'] = $row->hora_turno;
      $rowdata['id_tarea'] =  $this->tareas_model->select_tarea_byID($row->id_tarea)['nombreTarea'];
      $rowdata['id_gerencia'] = $this->gerencia_model->select_gerencia_byID($row->id_gerencia)['nom_gerencia'] ;
      $rowdata['estado_turno'] = $row->estado_turno;
      $rowdata['usuariocuit_inicioAtencion'] = $row->usuariocuit_inicioAtencion;
      $rowdata['fechaHora_inicioAtencion'] = $row->fechaHora_inicioAtencion;
      $rowdata['usuariocuit_finAtencion'] = $row->usuariocuit_finAtencion;
      $rowdata['fechaHora_finAtencion'] = $row->fechaHora_finAtencion;
      $rowdata['observacion'] = $row->observacion;
      $rowdata['id_delegacion'] = $this->delegacion_model->select_delegacion_byID($row->id_delegacion)['nom_delegacion'] ;
      $turnos[]        = $rowdata;
    }
    return $turnos;
  }

  public function comprobarDisponibilidad($start,$cantidad,$iddelegacion, $idgerencia, $idtarea){
    $datostarea = $this->tareasxdelegacion_model->select_tareasxdelegacion_ymas($iddelegacion, $idgerencia, $idtarea);
    $fecha = date('Y-m-j');
    $fecha = date('Y-m-d',strtotime ( '+'.($start-1).' day' , strtotime($fecha)));
    $i=1;
    $bloqueo='';
    $enddate = strtotime($datostarea['hora_fin_atencion']);
    $intervalo=$datostarea['intervalo'];
    $hayturnos = 0;
    $cantidad = $cantidad - ($start-1);

    while ($i <= $cantidad){
      $cant =0;
      $dias = date('Y-m-d',strtotime ( '+'.$i.' day' , strtotime($fecha)));

      if(date('l', strtotime ( $dias ))!='Saturday' &&
              date('l', strtotime ( $dias ))!='Sunday' && !$this->diasnolaborables_model->esdianolaboral($dias)){      
        $startdate = strtotime($datostarea['hora_inicio_atencion']);
        while($startdate <= $enddate){
          $row_turno = $this->select_turno_byFHDG($dias,date("H:i:s", $startdate),$iddelegacion,$idgerencia);

          if (count($row_turno) < $datostarea['turnosmismohorario']){

            $cant++;
          }
          $startdate = strtotime("+$intervalo minutes", $startdate);
        }
        if($cant==0){
          $bloqueo .=' ['.date('m, d', strtotime($dias)).'],';
        }else{
          $hayturnos=1;
        }
      }

      $i++;
    }
    if($hayturnos==1){
      $bloqueo.=$hayturnos;
    }
   return $bloqueo;
  }
   public function selectCantidadxPuesto($fecha, $hora, $puesto){
     $turnos = array();
     $results = $this->db->query("SELECT * FROM turnos WHERE fecha_turno = '$fecha' and hora_turno='$hora' and puesto=$puesto and estado_turno='EN ESPERA'");
     foreach ($results->result() as $row)
     {
       $rowdata['id_turno']     = $row->id_turno;
       $rowdata['cuit']     = $row->cuit;
       $rowdata['fecha_turno'] = $row->fecha_turno;
       $rowdata['puesto'] = $row->puesto;
       $rowdata['hora_turno'] = $row->hora_turno;
       $rowdata['id_tarea'] =  $this->tareas_model->select_tarea_byID($row->id_tarea)['nombreTarea'];
       $rowdata['id_gerencia'] = $this->gerencia_model->select_gerencia_byID($row->id_gerencia)['nom_gerencia'] ;
       $rowdata['estado_turno'] = $row->estado_turno;
       $rowdata['usuariocuit_inicioAtencion'] = $row->usuariocuit_inicioAtencion;
       $rowdata['fechaHora_inicioAtencion'] = $row->fechaHora_inicioAtencion;
       $rowdata['usuariocuit_finAtencion'] = $row->usuariocuit_finAtencion;
       $rowdata['fechaHora_finAtencion'] = $row->fechaHora_finAtencion;
       $rowdata['observacion'] = $row->observacion;
       $rowdata['id_delegacion'] = $this->delegacion_model->select_delegacion_byID($row->id_delegacion)['nom_delegacion'] ;

       $turnos[]        = $rowdata;
     }
     return $turnos;
   }

}
  ?>
