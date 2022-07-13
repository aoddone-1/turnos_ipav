<?php

class Enlaces_model extends CI_Model{

  function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function select_enlace_byID($id) {
    $results = $this->db->query('SELECT * FROM ipav_enlaces WHERE id_enlace = '.$id);
    foreach ($results->result() as $row)
    {
        $data['id_enlace'] = $row->id_enlace;
        $data['titulo_enlace']    = $row->titulo_enlace;
        $data['resumen_enlace'] = $row->resumen_enlace;
        $data['texto_enlace'] = $row->texto_enlace;
        $data['url_enlace']    = $row->url_enlace;
        $data['imagen_enlace']    = 'images/galeria/enlaces/'.$row->imagen_enlace;
    }
    return $data;
  }

  public function select_enlace_byEnlace($enlace) {
    $results = $this->db->query('SELECT * FROM ipav_enlaces WHERE url_enlace = "'.$enlace.'";');
    if($results->num_rows()>0){
      foreach ($results->result() as $row)
      {
        $data['id_enlace'] = $row->id_enlace;
        $data['titulo_enlace']    = $row->titulo_enlace;
        $data['resumen_enlace'] = $row->resumen_enlace;
        $data['texto_enlace'] = $row->texto_enlace;
        $data['url_enlace']    = $row->url_enlace;
        $data['imagen_enlace']    = 'images/galeria/enlaces/'.$row->imagen_enlace;
      }
    }else{ $data=null;}
      return $data;
    }

   public function update_enlace($enlace){
    $save = array(
        'titulo_enlace' => $enlace['titulo_enlace'],
        'resumen_enlace' => $enlace['resumen_enlace'],
        'texto_enlace' => $enlace['texto_enlace'],
        'url_enlace' => $enlace['url_enlace'],
        'imagen_enlace' => $enlace['imagen_enlace'],
    );
    $this->db->where('url_enlace', $enlace['url_enlace']);

    return $this->db->update('ipav_enlaces', $save);
  }

  public function insert_enlace($enlace){
    $save = array(
       'titulo_enlace' => $enlace['titulo_enlace'],
       'resumen_enlace' => $enlace['resumen_enlace'],
       'texto_enlace' => $enlace['texto_enlace'],
       'url_enlace' => $enlace['url_enlace'],
       'imagen_enlace' => $enlace['imagen_enlace']);


    $getResults=$this->db->insert('ipav_enlaces', $save);

    if ($getResults == FALSE) {
         return FALSE;
    } else {
         return TRUE;
    }
  }

  public function delete_enlace_byURL($url){

    $this->db->where('url_enlace', $url);

    return $this->db->delete('ipav_enlace');
  }

}
  ?>
