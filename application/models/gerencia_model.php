<?php

class Gerencia_model extends CI_Model{

  function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->model('enlaces_model');
  }

  public function select_gerencia_byID($id) {
    $results = $this->db->query('SELECT * FROM ipav_gerencia WHERE id_gerencia = '.$id);
    foreach ($results->result() as $row)
    {
        $data['id_gerencia'] = $row->id_gerencia;
        $data['nom_gerencia']    = $row->nom_gerencia;
        $data['gerente'] = $row->gerente;
        $data['imggerencia']    = $row->imggerencia;
        $data['nivel']    = $row->nivel;
        $data['url']    = $row->url;
    }
    return $data;
  }


  public function select_gerencia(){
    $gerencia = array();
    $results = $this->db->query("SELECT * FROM ipav_gerencia WHERE gerente!='-'");
    foreach ($results->result() as $row){
      $rowdata['id_gerencia'] = $row->id_gerencia;
      $rowdata['nom_gerencia']    = $row->nom_gerencia;
      $rowdata['gerente']    = $row->gerente;
      $rowdata['imggerencia']    = $row->imggerencia;
      $rowdata['nivel']    = $row->nivel;
      $rowdata['url']    = $row->url;
      $resumen = $this->enlaces_model->select_enlace_byEnlace($row->url);
      if(!empty($resumen)){
        $rowdata['resumen'] = $resumen['resumen_enlace'];
      }else{
        $rowdata['resumen'] = " ";
      }
      $gerencia[]        = $rowdata;
    }
    return $gerencia;

  }
  public function select_levels(){
    $niveles = array();
    $results = $this->db->query("SELECT distinct nivel FROM ipav_gerencia WHERE gerente!='-'");
    foreach ($results->result() as $row){
      $rowdata['nivel'] = $row->nivel;
      $niveles[]        = $rowdata;
    }
    return $niveles;

  }

  public function insert_gerencia($gerencia){
    $save = array(
       'nom_gerencia' => $gerencia['nom_gerencia'],
       'gerente' => $gerencia['gerente'],
       'imggerencia' => $gerencia['imggerencia'],
       'nivel' => $gerencia['nivel'],
       'url' => $gerencia['enlace']);


    $getResults=$this->db->insert('ipav_gerencia', $save);

    if ($getResults == FALSE) {
         return FALSE;
    } else {
         return TRUE;
    }
  }

  public function update_gerencia($gerencia){
    $save = array(
        'nom_gerencia' => $gerencia['nom_gerencia'],
        'gerente' => $gerencia['gerente'],
        'nivel' => $gerencia['nivel'],
        'url' => $gerencia['url'],
    );
    $this->db->where('id_gerencia', $gerencia['id_gerencia']);

    return $this->db->update('ipav_gerencia', $save);
  }

  public function cargar_img_gerencia($gerencia){
    $save = array(
        'imggerencia' => $gerencia['imagen'],
    );
    $this->db->where('id_gerencia', $gerencia['id_gerencia']);

    return $this->db->update('ipav_gerencia', $save);
  }

  public function delete_gerencia($id_gerencia){

    $this->db->where('id_gerencia', $id_gerencia);

    return $this->db->delete('ipav_gerencia');
  }
}
  ?>
