<html class="no-js" lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Turnos Online - IPAV</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?=base_url()?>images/turnos/ico.png" />
    <script src="<?=base_url()?>vendor/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="<?=base_url()?>vendor/jquery/jquery-ui.css">
    <script src="<?=base_url()?>vendor/jquery/jquery-ui.js"></script>
    <script src="<?=base_url()?>js/turnos/moment.js" type="text/javascript"></script>

    <link rel="stylesheet" href="<?=base_url()?>vendor/bootstrap/css/bootstrap.min.css">
    <script src="<?=base_url()?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <link href="<?=base_url()?>css/turnos/accionesusuario.css" rel="stylesheet" type="text/css"/>
    <!--        <link rel="stylesheet" href="css/bootstrap-theme.min.css">-->

    <script src="<?=base_url()?>js/turnos/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
  </head>
  <body >
    <?php
    include_once 'turnos_navbar_view.php'; ?>

      <main role="main" class="container container-fluid " id="container">
        <br/>


        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 text-center">
                <div class="card" id="paso5" >
                    <div class="card-body">
                      <h1 style="size:1em;"><?php echo $usuario['apellido'].', '.$usuario['nombre'] ?></h1>
                      <h2 style="size:1em;">Turno Número <?php echo $id_turno ?></h2>
                      <?php if($fecha!=null && $hora!=NULL) {?>
                        <?php if($puesto!=null) {?>
                        <div class='alert alert-success' role='alert'>
                          <h3 style="size:1em;">PUESTO DE ATENCION N° <?php echo $puesto ?></h3>
                        </div>
                      <?php } ?>
                      <p>Usted será atendido el dia <strong><?php echo $fecha ?></strong> a las <strong><?php echo $hora ?></strong>.</p>
                      <p>En la delegación de <strong><?php echo $delegacion['nom_delegacion'] ?></strong></p>
					  <?php if($tarea['id_tarea']==28 && $delegacion['id_delegacion']==2){ ?>
              <div class='alert alert-success' role='alert'>
						<h3><p>Deberá ingresar al Instituto por calle Sargento Cabral</p></h3>
              </div>
					  <?php }else{ ?>
						<p>Deberá dirigirse a la gerencia <strong><?php echo $gerencia['nom_gerencia'] ?></strong>
					   <?php }?>

                      para ser atendido por <strong><?php echo $tarea['nombreTarea'] ?></strong></p>

                      <?php if($tarea['id_tarea']==28){ ?>
                        <input type='hidden' name='campooblig' id='campooblig'  value='Solicita turno por Ayuda con DDJJ'></br>

                      <div class='alert alert-warning' role='alert'>
                        <H4>DEBE CONCURRIR CON EL DNI DEL TITULAR Y CON LA DOCUMENTACION QUE VERIFIQUE SUS INGRESOS</H4>

                      </div>
                      <?php } ?>
                      <div class="alert-danger" role="alert">
                        Por favor, presentese SOLO <strong>5 MINUTOS</strong> antes con su documento
                        para así evitar esperar en lugares compartidos.
                        El personal lo llamará por su nombre.
                      </div>
                      <div class="alert alert-danger " role="alert">
<strong>
                        En caso de no asistir, no olvide cancelar el <br>
                        turno, asi otra persona puede tomar su lugar.
        </strong>              </div>
                    <?php } else {?>
                      <p>Un agente de <strong><?php echo $gerencia['nom_gerencia'] ?></strong> se comunicará
                        con usted para coordinar <strong>día</strong> y <strong>hora</strong> de su turno.</p>
                      <p>Será atendido por <strong><?php echo $tarea['nombreTarea'] ?></strong> en la delegación de <strong><?php echo $delegacion['nom_delegacion'] ?></strong></p>


                      <div class="alert-danger" role="alert">
                        Por favor, presentese SOLO <strong>5 MINUTOS</strong> antes con su documento
                        para así evitar esperar en lugares compartidos.
                        El personal lo llamará por su nombre.
                      </div>
                    <?php } ?>
                    </div>
                    <div class="btn-toolbar justify-content-between" role="toolbar" >
                        <div class="input-group">
                            <a class="btn btn-light" href="home" role="button">Volver a Mis Turnos</a>
                        </div>
                        <div class="input-group">

                        </div>
                    </div>


                </div>
            </div>
        </div>
      </main>
  </body>

</html>
