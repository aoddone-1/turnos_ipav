<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Turnos Online - IPAV - Registrar Usuario</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?=base_url()?>images/turnos/ico.png">
        <script src="<?=base_url()?>js/turnos/jquery-3.6.0.min.js"></script>
<!--        <script src="https://code.jquery.com/jquery-3.5.0.js"></script>-->

        <link rel="stylesheet" href="<?=base_url()?>css/turnos/bootstrap.min.css">
        <script src="<?=base_url()?>js/turnos/bootstrap.min.js"></script>
        <!--<link rel="stylesheet" href="css/bootstrap-theme.min.css">-->
        <link rel="stylesheet" href="<?=base_url()?>css/turnos/registrarUsuario.css">
        <script src="<?=base_url()?>js/turnos/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        <script src="<?=base_url()?>js/turnos/funcionesVarias.js"></script>
        <style>
          .invalid {
            border: 2px solid red;
          }

        </style>
        <script>
        
        function CargarLocalidadesProvincia(val){
            $.ajax({
                type: "POST",
                url: '<?=base_url()?>turnos/consultaLocalidades',
                data: 'idlocalidad='+val,
                success: function(resp){
                    $('#selectloc').html(resp);
                }
            });
        }
        $(document).ready(function(){
            $('#form-registrar').submit(function(event){
              $.ajax({
                    url: '<?=base_url()?>turnos/registrar_usuario',
                    type: "POST",
                    data: $('#form-registrar').serialize(),
                    dataType: 'json',
                    success: function(data){
                      document.getElementById("email").className = "form-control";
                      document.getElementById("emailconfir").className = "form-control";
                      document.getElementById("cuit").className = "form-control";
                      document.getElementById("codArea").className = "form-control";
                      document.getElementById("telefono").className = "form-control";
                      document.getElementById("codAreaC").className = "form-control";
                      document.getElementById("celular").className = "form-control";
                      $('#mensajeContacto').html(null);
                      $('#mensajeCuit').html(null);
                      $('#mensajeCorreo').html(null);
                      if(data.code=='cuitinvalido'){
                          document.getElementById("cuit").className = "form-control invalid";
                          $('#mensajeCuit').html("\n"+data.message);
                      }else{
                        if(data.code=='empleado'){
                            document.getElementById("cuit").className = "form-control invalid";
                            $('#mensajeCuit').html(data.message);
                        }else{
                          if(data.code=='repetido'){
                              document.getElementById("cuit").className = "form-control invalid";
                              $('#mensajeCuit').html(data.message);
                          }else{
                            if(data.code=='telefono'){
                              document.getElementById("codArea").className = "form-control invalid";
                              document.getElementById("telefono").className = "form-control invalid";
                              document.getElementById("codAreaC").className = "form-control invalid";
                              document.getElementById("celular").className = "form-control invalid";
                              $('#mensajeContacto').html(data.message);
                            }else{
                              if(data.code=='correo'){
                                document.getElementById("email").className = "form-control invalid";
                                document.getElementById("emailconfir").className = "form-control invalid";
                                $('#mensajeCorreo').html(data.message);
                              }else{
                                if(data.code=='OK'){
                                  document.getElementById("cuit").value=null;
                                  document.getElementById("email").value=null;
                                  document.getElementById("emailconfir").value=null;
                                  document.getElementById("nombre").value=null;
                                  document.getElementById("apellido").value=null;
                                  document.getElementById("selectprov").value="";
                                  document.getElementById("selectloc").value="";
                                  document.getElementById("calle").value=null;
                                  document.getElementById("altura").value=null;
                                  document.getElementById("dpto").value=null;
                                  document.getElementById("codArea").value=null;
                                  document.getElementById("telefono").value=null;
                                  document.getElementById("codAreaC").value=null;
                                  document.getElementById("celular").value=null;

                                  $('#mensaje').html(data.message);
                                }
                              }
                            }
                          }
                        }
                      }






                    }
                });
                event.preventDefault();
            });
          });
        </script>


    </head>
    <body>
      <center>
        <div class="container-header">
          <h1 class="mb-5">Registrar Usuario</h1>
          <form id="form-registrar" autocomplete="off" class="form needs-validation"  method="POST" >
            <div class="row">

              <div class="form-group col-lg-3 col-12"  >
                <label for="cuit" class="text-info">CUIT/CUIL *</label><br>
                <input type="text" placeholder="ej. 20192837465" name="cuit" id="cuit" class="form-control" required maxlength = "11" pattern="[0-9]{10,11}"  title="El CUIT debe ser ingresado sin guiones ni puntos">
              </div>
              <div style="max-width: 100%;" class="col-lg-3 col-12" id="mensajeCuit">

              </div>
            </div>
            <div class="row">
              <div class="form-group col-lg-6 col-12"  >
                  <label for="nombre" class="text-info">Nombre *</label><br>
                  <input required title="Debe ingresar su nombre" type="text" class="form-control" name="nombre" id="nombre"/>
              </div>
              <div class="form-group col-lg-6 col-12"  >
                  <label for="apellido" class="text-info">Apellidos *</label><br>
                  <input required title="Apellidos" type="text" class="form-control" name="apellido" id="apellido"/>
              </div>
            </div>
            <b><label class="text-info">Datos de Domicilio ACTUAL</label></b>
            <div class="row">
              <div class="form-group col-lg-6 col-12"  >
                <label for="selectprov" class="text-info">Provincia *</label><br>
                <select name="selectprov"  id="selectprov" class="form-control" required onchange="CargarLocalidadesProvincia(this.value);">
                  <option value="">Seleccionar</option>
                  <?php for ($i=0; $i < count($provincia); $i++) { ?>
                    <option value="<?php echo $provincia[$i]['idprovincias']; ?>"><?php echo $provincia[$i]['nombre_provincia']; ?></option>
                  <?php } ?>

                </select>
              </div>
              <div class="form-group col-lg-6 col-12">
                  <label for="selectloc" class="text-info">Localidad *</label><br>
                  <select name="selectloc"  id="selectloc" class="form-control" required>
                    <option value="">Seleccionar</option>
                  </select>
              </div>
              <div class="form-group col-lg-12 col-12">
                   <label for="calle" class="text-info" >Calle *</label><br>
                   <input type="text" name="calle" placeholder="ej: Av. Pedro Luro" id="calle" required class="form-control" >
              </div>
              <div class="form-group col-lg-6 col-6">
                  <label class="text-info">Número * </label><br>
                  <input type="text" placeholder="ej: 742" pattern="[0-9]{1,4}" required title="La Altura debe contener solo números" name="altura" id="altura" class="form-control" maxlength = "4">
              </div>
              <div class="form-group col-lg-6 col-6">
                <label class="text-info">Departamento </label><br>
                <input type="text" placeholder="ej: A PA o 2 PB"  name="dpto" id="dpto" class="form-control">
              </div>
            </div>
            <b><label class="text-info">Datos de Contacto</label></b>

            <div class="row">
              <div  class="container" id="mensajeContacto"></div>
              <div class="form-group col-lg-6 col-12">
                  <label class="text-info">Teléfono </label><br>
                  <div class="form-row">
                    <label class="text-info">(</label>
                    <div class="col">
                      <input type="text" placeholder="Cod. Área" pattern="[0-9]{3,4}" title="El código de Área debe contener solo números" name="codArea" id="codArea" class="form-control" maxlength = "4">
                    </div>
                    <label class="text-info">) </label>
                    <div class="col">
                      <input type="text" placeholder="Número" pattern="[0-9]{6,8}" title="El número de Teléfono debe contener solo números" name="telefono" id="telefono" class="form-control" maxlength = "8">
                    </div>
                  </div>
              </div>
              <div class="form-group col-lg-6 col-12">
                  <label class="text-info">Celular </label><br>
                  <div class="form-row">
                    <label class="text-info">(</label>
                    <div class="col">
                      <input type="text" placeholder="Cod. Área"  title="El código de Área debe contener solo números" name="codAreaC" id="codAreaC" class="form-control" maxlength = "4">
                    </div>
                    <label class="text-info">) 15 - </label>
                    <div class="col">
                      <input type="text" placeholder="Número" pattern="[0-9]{6,8}" title="El número de Celular debe contener solo números" name="celular" id="celular" class="form-control" maxlength = "8">
                    </div>
                  </div>
              </div>
              <div  class="container" id="mensajeCorreo"></div>
              <div class="form-group col-lg-6 col-12">
                  <label for="email" class="text-info" >E-Mail </label><br>
                  <input type="email"  name="email" id="email" class="form-control" >
              </div>
              <div class="form-group col-lg-6 col-12">
                  <label for="emailconfir" class="text-info" >Confirme E-Mail </label><br>
                  <input type="email"  name="emailconfir" id="emailconfir" class="form-control" >
              </div>

            </div>
            <div style="max-width: 100%;" class="container" id="mensaje">

            </div>
            <div class="btn-toolbar justify-content-between" role="toolbar" >
                <div class="input-group">
                    <a class="btn btn-light" href="login" role="button">Atrás</a>
                </div>

                <div class="input-group">
                  <button type="submit" class="btn btn-primary"  id="btn-registrar" >
                     Registrar
                  </button>
                </div>
            </div>
          </form>


        </div>
      </center>
    </body>
</html>
