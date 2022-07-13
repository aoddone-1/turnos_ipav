<?php

class Usuario_model extends CI_Model{

  function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function cuitValido($cuit){
      $coeficiente[0]=5;
      $coeficiente[1]=4;
      $coeficiente[2]=3;
      $coeficiente[3]=2;
      $coeficiente[4]=7;
      $coeficiente[5]=6;
      $coeficiente[6]=5;
      $coeficiente[7]=4;
      $coeficiente[8]=3;
      $coeficiente[9]=2;

      $resultado=1;
      $cuit_rearmado='';
      for ($i=0; $i < strlen($cuit); $i= $i +1) {    //separo cualquier caracter que no tenga que ver con numeros
          if ((Ord(substr($cuit, $i, 1)) >= 48) && (Ord(substr($cuit, $i, 1)) <= 57))
          {
              $cuit_rearmado = $cuit_rearmado . substr($cuit, $i, 1);
          }
      }
      if(strlen($cuit_rearmado)>=10){
          if (strlen($cuit_rearmado) == 10) {
              $cuit_rearmado = substr($cuit_rearmado, 0, 2).'0'.substr($cuit_rearmado, 2, 7).substr($cuit, 9, 1);
              echo $cuit_rearmado;
          }
          if (strlen($cuit_rearmado) == 11) { // si to estan todos los digitos

              $sumador = 0;
              $verificador = substr($cuit_rearmado, 10, 1); //tomo el digito verificador
              for ($i=0; $i <=9; $i=$i+1) {
                  $sumador = $sumador + (substr($cuit_rearmado, $i, 1)) * $coeficiente[$i];//separo cada digito y lo multiplico por el coeficiente
              }
              $resultado = $sumador % 11;
              $resultado = 11 - $resultado;  //saco el digito verificador
              $veri_nro = intval($verificador);
              if($veri_nro==0){
                $resultado=0;
              }
              if ($veri_nro != $resultado){
                  return false;
              }else{
                  return true;
              }
          }
      }else{
          return false;
      }
  }

  public function usuarioExiste($cuit){
    $this->db->where('cuit',$cuit);
    $q=$this->db->get('turnos_usuario');


    if($q->num_rows()>0){
      return TRUE;
    }else{
      return FALSE;
    }
  }
  public function select_usuario_byCuit($cuit){
    $results = $this->db->query('SELECT * FROM turnos_usuario WHERE cuit = '.$cuit);
    foreach ($results->result() as $row)
    {
        $data['cuit'] = $row->cuit;
        $data['num_doc']    = $row->num_doc;
        $data['nrotramite']       = $row->nrotramite;
        $data['nombre'] = $row->nombre;
        $data['apellido'] = $row->apellido;
        $data['email'] = $row->email;
        $data['telefono'] = $row->telefono;
        $data['celular'] = $row->celular;
        $data['id_localidad'] = $row->id_localidad;
        $data['domicilio'] = $row->domicilio;
        $data['numero'] = $row->numero;
        $data['dpto'] = $row->dpto;
    }
    return $data;
  }
  public function set_ingreso($cuit) {
      $save = array(
        'ultimo_ingreso' => date('Y-m-j H:i:s')
      );
      $this->db->where('cuit', $cuit);
      $getResults=$this->db->update('turnos_usuario', $save);

      if ($getResults == FALSE) {
          return FALSE;
      } else {
          return TRUE;
      }
  }

  public function insert_usuario($cuit, $num_doc,$numerotramite, $nombre, $apellido, $email, $telefono, $celular, $localidad,$calle,$altura,$dpto) {
//Insert Query
      $save = array(
         'cuit' => $cuit,
         'num_doc' => $num_doc,
         'nrotramite' => $numerotramite,
         'nombre' => strtoupper($nombre),
         'apellido' => strtoupper($apellido),
         'email' => $email,
         'telefono' => $telefono,
         'celular' => $celular,
         'id_localidad' => $localidad,
         'domicilio' => $calle,
         'numero' => $altura,
         'dpto' => $dpto
       );

      $getResults=$this->db->insert('turnos_usuario', $save);

      if ($getResults == FALSE) {
           return FALSE;
     } else {
           return TRUE;
      }
  }

  public function update_usuario($cuit, $nombre, $apellido, $email, $telefono, $celular, $localidad,$calle,$altura,$dpto) {
      $save = array(
        'nombre' => $nombre,
        'apellido' => $apellido,
        'email' => $email,
        'telefono' => $telefono,
        'celular' => $celular,
        'id_localidad' => $localidad,
        'domicilio' => $calle,
        'numero' => $altura,
        'dpto' => $dpto
      );
      $this->db->where('cuit', $cuit);
      $getResults=$this->db->update('turnos_usuario', $save);

      if ($getResults == FALSE or $rowsAffected == FALSE) {
          return FALSE;
      } else {
          return TRUE;
      }
  }
  public function update_usuario_dom($cuit,  $localidad,$calle,$altura,$dpto) {
      $save = array(
        'id_localidad' => $localidad,
        'domicilio' => $calle,
        'numero' => $altura,
        'dpto' => $dpto
      );
      $this->db->where('cuit', $cuit);
      $getResults=$this->db->update('turnos_usuario', $save);

      if ($getResults == FALSE or $rowsAffected == FALSE) {
          return FALSE;
      } else {
          return TRUE;
      }
  }


  //empleadoExiste
  public function empleadoExiste($cuit){
    $this->db->where('cuit',$cuit);
    $results=$this->db->get('turnos_empleado');
    foreach ($results->result() as $row) {
        $data['cuit'] = $row->cuit;
        $data['num_doc']    = $row->num_doc;
        $data['password']       = $row->password;
        $data['nombre'] = $row->nombre;
        $data['apellido'] = $row->apellido;
        $data['id_delegacion'] = $row->id_delegacion;
        $data['id_gerencia'] = $row->id_gerencia;
        $data['tipo_acceso'] = $row->tipo_acceso;
    }
    return $data;
  }

}
  ?>
