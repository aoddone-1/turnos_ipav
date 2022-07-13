<?php
if(($this->session->userdata('username'))){

 ?>
<html class="no-js" lang="es">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <title>Turnos Online - IPAV</title>
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="<?=base_url()?>images/turnos/ico.png">
      <script src="<?=base_url()?>js/turnos/jquery-3.6.0.min.js"></script>
<!--        <script src="https://code.jquery.com/jquery-3.5.0.js"></script>-->

      <link href="<?=base_url()?>css/turnos/accionesusuario.css" rel="stylesheet" type="text/css"/>
      <link rel="stylesheet" href="<?=base_url()?>vendor/bootstrap/css/bootstrap.min.css">
      <script src="<?=base_url()?>vendor/bootstrap/js/bootstrap.min.js"></script>
      <!--        <link rel="stylesheet" href="css/bootstrap-theme.min.css">-->

      <script src="<?=base_url()?>js/turnos/moment.js" type="text/javascript"></script>
      <script src="<?=base_url()?>js/turnos/modernizr-2.8.3-respond-1.4.2.min.js"></script>

      <script src="<?=base_url()?>js/turnos/funcionesVariasUsuarioComun.js" type="text/javascript"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
    </head>
    <body style="background-color: #508bfc;">
      <?php
      include_once 'turnos_navbar_view.php'; ?>
      <main id="content-wrapper">
        <div class="container-fluid">
          <br/>
          <div class="card border-primary mb-3">
            <div class="card-header text-info">
                <h4 class="card-title">Historial de Visitas</h4>
            </div>
            <div class="card-body">
              <div class="card-main">
                <?php if (count($turnos2)>0){ ?>
                  <div class="tableFixHeadW">
                    <table class = "table table-striped ">
                      <thead class = "thead-dark">
                        <tr>
                            <th class="text-center" scope = "col">Fecha</th>
                            <th class="text-center" scope = "col">Hora</th>
                            <th class="text-center" scope = "col">Motivo</th>
                            <th class="text-center" scope = "col">Situación</th>
                            <th class="text-center" scope = "col">Observación</th>
                        </tr>
                      </thead>
                      <tbody style="height: 10px !important; overflow: scroll; ">
                        <?php
                        for ($i=0; $i < count($turnos2); $i++) {
                            $dateh = ($turnos2[$i]['fecha_turno']);
                            if ($turnos2[$i]['estado_turno'] == "CANCELADO") {?>
                                <tr class="table-danger">
                            <?php } else { if($turnos2[$i]['estado_turno'] == "ATENDIDO"){ ?>
                                <tr class="table-success">
                          <?php  } else { ?>
                            <tr class="table-primary">
                          <?php  }} ?>
                          <td class="text-center align-middle" scope="row"><?php echo $dateh ?></td>
                          <td class="text-center align-middle">    <?php echo ($turnos2[$i]['hora_turno']); ?></td>
                          <td class="text-center align-middle" ><?php
                              /*$rows_show_t = $instaTa->select_tarea_byID($rowh['id_tarea']);
                              $rowt = sqlsrv_fetch_array($rows_show_t, SQLSRV_FETCH_ASSOC);*/
                              echo ($turnos2[$i]['id_tarea']);
                              ?></td>
                          <td class="align-middle text-center"><?php echo $turnos2[$i]['estado_turno']; ?></td>
                          <td class="align-middle text-center">
                              <?php echo $turnos2[$i]['observacion']; ?>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                <?php } else {
                    echo '<div class="tableFixHead"><p class="card-text alert alert-info">No Existen Turnos en el Historial.</p></div>';
                } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade fixed-top-2" id="observacionModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="observacionModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Observación de su Turno</h5>
                    </div>
                    <div class="modal-body">
                      <div class="card-body">
                        <b><p id=observacion></p></b>
                      </div>
                    </div>
                      <div class="modal-footer"  >
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      </div>
                  </div>
              </div>
          </div>
      </main>
    </body>
</html>
<?php }else{
	redirect('turnos/login');
} ?>
