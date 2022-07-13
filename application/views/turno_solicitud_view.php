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
    <!--        <script src="https://code.jquery.com/jquery-3.5.0.js"></script>-->
            <script src="<?=base_url()?>js/turnos/moment.js" type="text/javascript"></script>
            <link rel="stylesheet" href="<?=base_url()?>vendor/bootstrap/css/bootstrap.min.css">
            <script src="<?=base_url()?>vendor/bootstrap/js/bootstrap.min.js"></script>
            <link href="<?=base_url()?>css/turnos/accionesusuario.css" rel="stylesheet" type="text/css"/>
            <!--        <link rel="stylesheet" href="css/bootstrap-theme.min.css">-->

            <script src="<?=base_url()?>js/turnos/modernizr-2.8.3-respond-1.4.2.min.js"></script>
            <script src="<?=base_url()?>js/turnos/funcionesturno.js" type="text/javascript"></script>
            <script src="<?=base_url()?>js/turnos/funcionesVariasUsuarioComun.js" type="text/javascript"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
            <script>

              function CargarTareasDelegacion(val){
                  $.ajax({
                      type: "POST",
                      url: '<?=base_url()?>turnos/consultaTareas',
                      data: 'iddelegacion='+val,
                      success: function(resp){
                          $('#insert').prop("disabled",true);
                          $('#selecttarea').html(resp);

                      }
                  });
              }
              function CargarDias(tarea,delegacion){
                $('#tareapublic').html('<div class="loading text-center"><div class="spinner-border ml-auto text-danger" role="status" aria-hidden="true"></div></br><strong>AGUARDE</br>Estamos Buscando Dias Disponibles...</strong></div>');
                $.ajax({
                    type: "POST",
                    url: '<?=base_url()?>turnos/listaDias',
                    data: 'tarea='+tarea+'&delegacion='+delegacion,
                    success: function(resp){
                        $('#insert').prop("disabled",true);
                        $('#tareapublic').html(resp);
                    }
                });
              }
              function CargarHoras(dia,tarea,delegacion){

                $.ajax({
                    type: "POST",
                    url: '<?=base_url()?>turnos/listaHorarioDisponible',
                    data: 'dia='+dia+'&tarea='+tarea+'&delegacion='+delegacion,
                    success: function(resp){

                      $('#insert').prop("disabled",true);
                      $('#horarioselect').prop("disabled",false);
                      $('#horarioselect').html(resp);
                    }
                });
              }

              function CargarArea(hora,tarea,delegacion){
                $.ajax({
                    type: "POST",
                    url: '<?=base_url()?>turnos/seccionPersonalizada',
                    data: 'tarea='+tarea+'&delegacion='+delegacion,
                    success: function(resp){
                      if(hora==null){
                        $('#insert').prop("disabled",true);
                        $('#personalidado').html(resp);
                      }else{
                        $('#insert').prop("disabled",true);
                        $('#personalidado').html(resp);
                      }
                    }
                });
              }
              function activaBoton(select){
                $.ajax({
                    success: function(resp){
                      if($('#myCheck').is(":checked")) {
                        $('#insert').prop("disabled",false);
                      } else {
                        $('#insert').prop("disabled",true);
                      }



                    }
                });
              }

              function countChars(obj){
              //    alert('hola');
                  var maxLength = 150;
                  var strLength = obj.value.length;
                  var charRemain = (maxLength - strLength);

                  if(charRemain < 11){
                      document.getElementById("charNum").innerHTML = '<span style="color: red;">'+charRemain+' caracteres restantes</span>';
                  }else{
                      document.getElementById("charNum").innerHTML = charRemain+' caracteres restantes';
                  }
              }
            </script>
            <style>
            .intermitente{
                border: 1px solid black;
                padding: 5px 5px;
                box-shadow: 0px 0px 20px;
            }
            </style>
        </head>
        <body style="background-color: #508bfc;">

            <?php $navbaractive = 'solicitud_turno';
            include_once 'turnos_navbar_view.php'; ?>

            <main role="main" class="container container-fluid " id="container">
              <br/>

                <form id="turno-form" class="form needs-validation" autocomplete="off" method="POST" >

                    <div class="row">

                        <div class="col-md-3"></div>
                        <div class="col-md-6 text-center">

                            <div class="card" id="info" >
                                <div class="card-body">
                                  <?php if($localidad!=NULL) {
                                  ?>
                                  <div class="alert alert-danger" role="alert">
                                    <strong>ATENCIÓN!</strong><br/>
                                    Dado que su lugar de residencia es en la localidad de <strong> <?php echo $localidad ;?> </strong> le recomendamos que
                                    antes de reservar un turno se comunique telefónicamente para que el personal evalúe si es necesaria la atención presencial.<br/> Haciendo <a class="text-black" target="_blank" href="<?=base_url()?>contacto">CLICK AQUÍ</a>
                                    puede acceder al telefóno de las delegaciones y a los números de interno de cada gerencia.
                                  </div>
                                  <?php }
                                   ?>

                                        <div class="form-group">

                                            <label for="selectdeleg" class="text-info">Seleccione donde desea ser atendido.</label>
                                            <select name="selectdeleg" id="selectdeleg" class="form-control" required onchange="CargarTareasDelegacion(this.value);">
                                                <option value="" >Seleccione la Delegación</option>
                                                <?php
                                                for ($j=0; $j < count($delegaciones) ; $j++) {
                                                    echo "<option value='" . $delegaciones[$j]['id_delegacion'] . "'> " . $delegaciones[$j]['nom_delegacion'] . " </option>";

                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div  id="selecttarea"  class="form-group">


                                            <!--<label for="selecttarea" class="text-danger">No se atenderá si el motivo del turno no corresponde a la tarea que desea hacer</label>-->
                                        </div>
                                        <div id="tareapublic" class="form-group" >


                                        </div>



                                        <div  class="form-row">

                                            <button type="submit" disabled=true name="insert" id="insert" class="btn btn-primary" value="Insertar Datos">Confirmar Turno</button>

                                        </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </main>
        </body>

    </html>
