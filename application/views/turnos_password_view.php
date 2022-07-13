<html class="no-js" lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Turnos Online - IPAV</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?=base_url()?>images/turnos/ico.png">
        <script src="js/jquery-3.5.0.js"></script>
<!--        <script src="https://code.jquery.com/jquery-3.5.0.js"></script>-->
        <link href="<?=base_url()?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src="<?=base_url()?>vendor/bootstrap/js/bootstrap.js"></script>
        <!--<link rel="stylesheet" href="css/bootstrap-theme.min.css">-->
        <script src="<?=base_url()?>vendor/jquery/jquery.min.js"></script>
        <script src="<?=base_url()?>js/turnos/js/funcionesLogin.js"></script>
    </head>
    <body>
      <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
              <div class="card shadow-2-strong" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">

                  <div class="text-center">
                    <img src="<?=base_url()?>images/turnos/logoalternativo2.png" class="rounded img-fluid" style="width: 200px;" alt="Responsive image">
                    <br/>

                    <h4 class="mt-1 pb-1"> <?php echo $usuario['apellido'].", ".$usuario['nombre']; ?> </h4>
                  </div>
                  <form id="password-form" class="form" method="post">
                    <div class="form-outline mb-4">
                      <input type="password" name="password" id="password" required/><br/>
                      <label class="form-label text-info" for="password">Contraseña</label>
                    </div>
                    <label class="text-danger">
                         <?php
                             if(isset($errorlogin)){
                                 echo $errorlogin;
                             }
                         ?>
                     </label>

                    <button class="btn btn-primary btn-lg btn-block" type="submit">Entrar</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </body>
</html>
