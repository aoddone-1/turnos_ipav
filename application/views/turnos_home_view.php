<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
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

				<script>
				  $(document).ready(function()
				  {
				    // id de nuestro modal
				    $("#modalCompletar").modal("show");
				  });

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
				  </script>
		</head>
		<body style="background-color: #508bfc;">

				<?php
				if($usuario['id_localidad']==null){
						$this->load->view('modals/modal_turnos_completar.php');
				}
				?>
				<?php include_once 'turnos_navbar_view.php'; ?>


				<main id="content-wrapper">
						<div class="container-fluid justify-content-between" >
								<div id="feedback-bg-info" class="row">
										<div class="col-xs-12 col-lg-6">
											<br/>
												<div class="card border-primary mb-3 justify-content-between">
													<div class="card-header text-info">
														<h4 class="card-title">Turnos Pendientes para los proximos dias.</h4>
													</div>
													<div class="card-body">
														<div class="card-main">
															<?php if (count($turnos1)>0){ ?>
																<div class="tableFixHead">
																	<table class = "table table-striped table-hover table-sm table-bordered">
																		<thead class = "thead-dark">
																			<tr>
																					<th class="text-center" scope = "col">Fecha</th>
																					<th class="text-center" scope = "col">Hora</th>
																					<th class="text-center" scope = "col">Puesto</th>
																					<th class="text-center" scope = "col">Motivo</th>
																					<th></th>
																			</tr>
																		</thead>
																		<tbody>
																			<?php
                                      for ($i=0; $i < count($turnos1); $i++) {
                                        $date = ($turnos1[$i]['fecha_turno']);
																					?>
																					<tr>
																							<td class="text-center align-middle" scope="row"><?php if($date!=null){  echo (date("j/m/Y",strtotime($date))); } else { echo "--/--/----"; }?></td>
																							<td class="text-center align-middle">    <?php if($turnos1[$i]['hora_turno']!=null){   echo (date("h:i A",strtotime($turnos1[$i]['hora_turno']))); } else { echo "--:--"; } ?></td>
																							<td class="text-center align-middle">    <?php if($turnos1[$i]['puesto']!=0){ echo ($turnos1[$i]['puesto']); } else { echo "---"; }?></td>
																							<td class="text-center align-middle" ><?php

																									echo ($turnos1[$i]['id_tarea']);
																									?></td>
																							<td class="align-middle text-center">
																								<button class="btn btn-danger btn-cancelar"  data-toggle="modal" data-placement="right" title="Cancelar Turno" data-target="#cancelarModal" value="<?php echo $turnos1[$i]['id_turno']; ?>" >
																									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
																									  <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
																									  <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
																									  <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
																									</svg>
																								</button>

																							</td>
																					</tr>
																			<?php } ?>
																		</tbody>
																	</table>
																</div>
																<?php
																	} else {
																			echo '<p class="card-text alert alert-info">No tiene Turnos Pendientes para los proximos dias.</p>'
																			. '  <p><a class="btn btn-success" href="solicitud_turno">Solicitar Turno</a></p>';
																	}
																	?>
														</div>
													</div>
												</div>
												<div class="card border-primary mb-3" id="paso6" >
													<div class="card-body">
																<div id="datos" class="" >
																	<div class="alert alert-warning " role="alert">
																				En caso de solicitar un turno
																				presentese 5 minutos antes con su documento. <br>
																				El personal lo llamará por su nombre.<br>

																	</div>
																	<?php if (count($turnos1)>0){ ?>
																	<div class="alert alert-danger " role="alert">
																		En caso de no asistir, no olvide cancelar el <br>
																		turno solicitado, asi otra persona puede tomar su lugar.
																	</div>
																<?php } ?>
																</div>
														</div>
												</div>
										</div>
										<div class="col-xs-12 col-lg-6">
											<br/>
											<div class="card border-primary mb-3">
												<div class="card-header text-info">
													<h4 class="card-title">Historial de Visitas</h4>
												</div>
												<div class="card-body">
													<div class="card-main">
														<?php if (count($turnos2)>0){ ?>
															<div class="tableFixHeadComp">
																<table class = "table  table-sm table-bordered">
																		<thead class = "thead-dark">
																				<tr>
																						<th class="text-center" scope = "col">Fecha</th>
																						<th class="text-center" scope = "col">Hora</th>
																						<th class="text-center" scope = "col">Motivo</th>
																						<th class="text-center" scope = "col">Situación</th>
																				</tr>
																		</thead>
																		<tbody>
																				<?php
																				$j = 0;

																				while ($j < 5 && $j < count($turnos2)) {

																						$dateh = ($turnos2[$j]['fecha_turno']);

																						if ($turnos2[$j]['estado_turno'] == "CANCELADO") {
								                                echo '<tr class="table-danger">';
								                             } else { if($turnos2[$j]['estado_turno'] == "ATENDIDO"){
																								echo '<tr class="table-success">';
								                          	} else {
																							echo '<tr class="table-primary">';
								                           	}}
																						 ?>

																				<td class="text-center align-middle" scope="row"><?php  echo (date("j/m/Y",strtotime($dateh)));?></td>
																				<td class="text-center align-middle">    <?php echo (date("h:i A",strtotime($turnos2[$j]['hora_turno']))); ?></td>
																				<td class="text-center align-middle" ><?php
																						echo ($turnos2[$j]['id_tarea']);
																						?></td>
																				<td class="align-middle text-center"><?php echo $turnos2[$j]['estado_turno']; ?></td>
																				</tr>
																				<?php
																				$j = $j + 1;
																		}
																		?>

																		</tbody>
																</table>
															</div>
															<?php
															if (count($turnos2)>5) {
																echo '<a class="btn btn-primary" href="historial.php" >HISTORIAL COMPLETO</a>';
															}
														} else {
															echo '<p class="card-text alert alert-info">No tiene Turnos Anteriores.</p>';
														}
														?>
													</div>
													</div>
											</div>
										</div>
								</div>
						</div>

						<div class="modal fade fixed-top-2" id="cancelarModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="cancelarModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
										<div class="modal-content">
												<div class="modal-header">
														<h5 class="modal-title" id="cancelarModalLabel">Cancelar Turno</h5>
														<button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar">
																<span aria-hidden="true">&times;</span>
														</button>
												</div>
												<form id="cancelar-form" class="form" method="POST" action="home">
														<div class="modal-body">
																<p>Esta seguro que desea cancelar el turno?</p>
														</div>
														<div class="modal-footer"  >
																<input type="hidden" name="idturno" id="idturno" value="" />
																<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
																<button type="submit" name="update" class="btn btn-danger" value="cancelar">Cancelar Turno</button>
														</div>
												</form>
										</div>
								</div>
						</div>
						<?php
				/*		if (isset($_GET['insert'])) {
								$res = filter_input(INPUT_GET, 'insert');
								if (strcmp($res, "success") == 0) {
									print ('<div class="toast alert alert-success fixed-top-2 "  data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 0; right: 0;background:#D4EDDA;">

														<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
														<span aria-hidden="true">&times;</span>
														</button>


														<div class="toast-body">
														El turno se ha solicitado Correctamente.
														</div>
												</div>
											 ');
								} else {
										print ('<div class="toast alert alert-danger fixed-top-2" data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 0; right: 0;background:#F8D7DA;">
														<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
														<span aria-hidden="true">&times;</span>
														</button>
														<div class="toast-body">
														Ocurrió un Error al Guardar los datos.
														</div>
												</div>
											 ');
								}
						}
						if (isset($_GET['update'])) {
								$res = filter_input(INPUT_GET, 'update');
								if (strcmp($res, "success") == 0) {
										print ('<div class="toast alert alert-success fixed-top-2" data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 0; right: 0;background:#D4EDDA;">
												<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
												<div class="toast-body ">
												El turno se cancelo Correctamente.
												</div>
										</div>
								');
								} else {
										print ('<div class="toast alert alert-danger fixed-top-2" data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 0; right: 0;background:#F8D7DA;">
												<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
												<div class="toast-body">
												Ocurrió un Error al cancelar el turno.
												</div>
										</div>
										');
								}
						}*/
						?>
				</main>



		</body>

</html>
<?php /*}else{
	redirect('turnos/login');
} */?>
