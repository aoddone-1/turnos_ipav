
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <ul class="navbar-nav mr-auto">
      <a class="navbar-brand" href="home"><img src="<?=base_url()?>images/turnos/icono2.png" class="rounded img-fluid float-left"></a>
      <a class="navbar-brand" href="home">Inicio</a>
    </ul>

</nav>
<nav class="navbar navbar-expand-md navbar-light bg-light  fixed-top fixed-top-4">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item <?php //if($navbaractive=='historial'){echo 'active';}?>" >
            <a class="nav-link" href="historial">Historial</a>
        </li>
        <li class="nav-item  <?php //if($navbaractive=='solicitud_turno'){echo 'active';}?>" >
            <a class="nav-link" href="solicitud_turno">Solicitud de Turnos</a>
        </li>
      </ul>
  </div>
  <ul class="nav justify-content-end">
    <li class="nav-item">
      <a class="btn btn-primary text-white" role="button" aria-disabled="true" href="<?php echo site_url('turnos/logout') ?>">Salir</a>
    </li>
  </ul>
</nav>
