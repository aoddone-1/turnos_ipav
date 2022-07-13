<?php

class Visitas_model extends CI_Model{

    const NAME        = 'Ipav';
    const IMAGEFOLDER = '../images/galeria/';

    function __construct(){
        parent::__construct();
		    $this->load->database();
		}


    /******************************* -- ipav --*************************************/

    function setVisitas($titulo,$icono,$visita){
      $fecha_actual = date('Y-m-d');
      $results = $this->db->query("SELECT * FROM ipav_visitas WHERE enlace = '".$visita."' and mesanio='".$fecha_actual."'");

      if($results->num_rows()>0){
        foreach ($results->result() as $row1){
          $save2 = array(
            'icono' => $icono,
            'titulo' => $titulo,
           'enlace' => $visita,
           'visitas' => $row1->visitas+1,
           'mesanio' => $fecha_actual,
           'fecha_ultvisita'=>date('Y-m-d H:i:s'));

            $this->db->where('enlace', $visita);
            $this->db->where('mesanio', $fecha_actual);
            $getResults=$this->db->update('ipav_visitas', $save2);
            if ($getResults == FALSE ) {
                return FALSE;
            } else {
                return TRUE;
            }

        }
      }else{
        $save = array(
            'icono' => $icono,
            'titulo' => $titulo,
           'enlace' => $visita,
           'visitas' => 1,
           'mesanio' => $fecha_actual,
           'fecha_ultvisita' => date('Y-m-d H:i:s'));
          $getResults=$this->db->insert('ipav_visitas', $save);
          if ($getResults == FALSE) {
               return FALSE;
          } else {
               return true;
          }
      }

    }

    function getMasVisitados(){
      $enlaces = array();
      $results = $this->db->query("SELECT titulo,icono, enlace, SUM(visitas) as cant_visitas"
                                  . " FROM ipav_visitas"
                                  . " WHERE enlace not like '%/noticia/%' and "
                                  . " 		  enlace not like '%/planes/%' and "
                                  . " 		  enlace not like '%/gerencia%' and "
                                  . " 		  enlace not like '%ipav.lapampa.gob.ar/' and"
                                  . " 		  enlace not like '%ipav-test.lapampa.gob.ar/%'"
                                  . " group by enlace "
                                  . " order by cant_visitas desc "
                                  . " limit 5 "
                                  );
      foreach ($results->result() as $row){
        $rowdata['icono'] = $row->icono;
        $rowdata['titulo'] = $row->titulo;
        $rowdata['enlace'] = $row->enlace;
        $rowdata['cant_visitas']    = $row->cant_visitas;

        $enlaces[]        = $rowdata;
      }
      return $enlaces;
    }

}
?>
