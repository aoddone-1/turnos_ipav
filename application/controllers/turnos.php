<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Turnos extends CI_Controller {

	function __construct(){
		parent::__construct();
        $this->load->helper('url');
				$this->load->library('session');
				$this->load->model('usuario_model');
				$this->load->model('turnos_model');
				$this->load->model('diasnolaborables_model');
				$this->load->model('delegacion_model');
				$this->load->model('gerencia_model');
				$this->load->model('tareas_model');
				$this->load->model('tareasxdelegacion_model');
				$this->load->model('parametros_model');
				$this->load->model('empleado_model');
				$this->load->model('provincia_model');
				$this->load->model('localidad_model');
	}

	public function index(){
	    $data['base_url']        = $this->config->base_url();
	    $data['gerencias']        = $this->getGerencias();
	    redirect('turnos/login');
	}

function getEnlace($url){
	 $return = $this->enlaces_model->select_enlace_byEnlace($url);
	 return $return;
 }
 function getGerencias(){
		$return = $this->gerencia_model->select_gerencia();
		return $return;
	}

/*	public function enviarEmail(){
		// PHPMailer object

    $oMail = $this->phpmailer_library->load();
		// SMTP configuration
		$oMail->isSMTP();
	  $oMail->Host="smtp.gmail.com";
	  $oMail->Port=465;
	  $oMail->SMTPSecure="TLS/SSL";
	  $oMail->SMTPAuth=true;
	  $oMail->Username="noticias.ipav@gmail.com";
	  $oMail->Password="ipav*admin2016";
	  $oMail->setFrom("noticias.ipav@gmail.com","IPAV Noticias");
	  $oMail->CharSet = 'UTF-8';

		$oMail->addAddress('anitaoddone@gmail.com', 'Ana Oddone');
		$oMail->Subject="IPAV - Turno Confirmado";
		$oMail->msgHTML('Esto es un correo electronico');

		// Send email
    if(!$oMail->send()){
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $oMail->ErrorInfo;
    }else{
        echo 'Message has been sent';
    }
	}*/

	public function login(){
		if(($this->session->userdata('username'))){
			redirect('turnos/home');
		}

		if(isset($_POST['cuit'])){
			$cuit=$_POST['cuit'];

			$results=$this->usuario_model->usuarioExiste($cuit);
			if($results){
				$arraydata = array(
                'username'  => $cuit
        );

				$this->session->set_userdata($arraydata);
				$this->usuario_model->set_ingreso($cuit);
				echo $this->session->userdata('username');

				redirect('turnos/home');
			}else{
				$results=$this->usuario_model->empleadoExiste($cuit);
				if(count($results)>0){
					$data['usuario'] = $results;
					$this->load->view('turnos_password_view',$data);
				}else{
					$data['errorlogin'] = "El cuit no correspode a un usuario. Debe Registrarse.";
				}

				//redirect('turnos/login');
			}
		}
		$data['base_url']        = $this->config->base_url();
		$this->load->view('turnos_inicio_view', $data);
	}

	public function incio_empleado(){
		$this->load->view('turnos_inicio_empleado_view');
	}

	public function logout(){
		$this->session->set_userdata(null);
		$this->session->sess_destroy();

		redirect('turnos/login');
	}

	public function home(){
		if($this->session->userdata('username')!=NULL){
			$data['provincia']= $this->provincia_model->select_provincias();
			$data['base_url']        = $this->config->base_url();
			$cuit = $this->session->userdata('username');

			if(isset($_POST['update'])){
				$idturno = $_POST['idturno'];

				$result = $this->turnos_model->cambiar_estadoandobs('CANCELADO', 'TURNO CANCELADO EL DÍA '.date('j/m/Y H:i').' POR EL USUARIO', $idturno);
			}

			$data['usuario'] = $this->usuario_model->select_usuario_byCuit($cuit);
			$data['turnos1'] = $this->turnos_model->select_turno_byPersonaEstado("EN ESPERA", $cuit);
			$data['turnos2'] = $this->turnos_model->select_turno_byhistorial($cuit);
			$this->load->view('turnos_home_view',$data);
		}else{
			redirect('turnos/logout');
		}
	}

	public function historial(){
		if($this->session->userdata('username')!=NULL){
			$data['base_url']        = $this->config->base_url();
			$cuit = $this->session->userdata('username');
			$data['usuario'] = $this->usuario_model->select_usuario_byCuit($cuit);
			$data['turnos2'] = $this->turnos_model->select_turno_byhistorial($cuit);
			$this->load->view('turnos_historial_view',$data);
		}else{
			redirect('turnos/login');
		}

	}

	public function solicitud_turno(){
	if($this->session->userdata('username')!=NULL){
		$data['base_url']        = $this->config->base_url();
		$cuit = $this->session->userdata('username');
		$user = $this->usuario_model->select_usuario_byCuit($cuit);
		$data['usuario'] = $user;
		$data['diasnolaborables'] = $this->diasnolaborables_model->select_diasnolaborables();
		$data['delegaciones'] = $this->delegacion_model->select_delegaciones();
		$data['tareas'] = $this->tareas_model->select_tareas();
		$data['localidad']=null;
			if(!isset($_POST['insert'])){
				if($user['id_localidad']!=35 && $user['id_localidad']!=33 && $user['id_localidad']!=73){
					$loc=$this->localidad_model->select_localidades_byID($user['id_localidad']);
					$data['localidad']=$loc['nombre_loc'];
				}

				$this->load->view('turno_solicitud_view',$data);
			}else{
				//$this->load->view('turno_solicitud_view',$data);
				$cuit = $this->session->userdata('username');
				$id_delegacion = $_POST["selectdeleg"];
				$id_tarea = $_POST['tareas'];
				$fecha_turno=null;
				$hora_turno=null;
				$observacion=null;
				$result = $this->tareasxdelegacion_model->select_tareasxdelegacion_byID($id_delegacion,$id_tarea);
				if($result['privacidad']=='PUBLICO'){
					$fecha_turno = date('Y-m-d',strtotime($_POST['calendario']));
					$hora_turno = $_POST['horarioselect'];
				}
				$tienepuesto = $result['tienepuestos'];
				$observacion=$_POST['campooblig'];


				$rows_tareas = $this->tareas_model->select_tarea_byID($id_tarea);
				$id_gerencia=$rows_tareas['id_gerencia'];


				$observacion= "Observación ingresada el <strong>".date('j/m/Y h:i')."</strong> Por: <strong>".$user['apellido'].", ".$user['nombre']."</strong><br/><k>".$observacion."</k>";

				$data['gerencia']= $this->gerencia_model->select_gerencia_byID($id_gerencia);
				$data['delegacion']= $this->delegacion_model->select_delegacion_byID($id_delegacion);
				$data['fecha']= $fecha_turno;
				$data['hora']= $hora_turno;
				$data['tarea']= $this->tareas_model->select_tarea_byID($id_tarea);


				$turnos=$this->turnos_model->select_turno_byPersonaEstado("EN ESPERA",$cuit);
				//comprueba que no tenga mas de 5 turnos en espera
				if(count($turnos)<5){
					//comprueba que no tenga turnos en ese dia y horario
					$turnos=$this->turnos_model->select_turno_byFechaHora($cuit, $fecha_turno,$hora_turno);
					if(count($turnos)==0){
						//turno en esa gerencia y delegacion
						$turnos = $this->turnos_model->select_turno_byGerenciayDelegacion($cuit,$id_gerencia,$id_delegacion);
						if(count($turnos)==0){
							$turnos = $this->turnos_model->select_turno_byTarea($cuit,$id_tarea);
							if(count($turnos)==0){
								$rows_parametro = $this->parametros_model->select_parametros_byIDs($id_delegacion,$id_gerencia);
								$cant_alavez=$rows_parametro['turnosmismohorario'];
								$turnos = $this->turnos_model->select_turno_byreserva($fecha_turno, $hora_turno, $id_delegacion, $id_tarea, $id_gerencia);
								if(count($turnos)<$cant_alavez){
									$puesto = 0;
									if($tienepuesto){
										$i=1;
										while ($i<=$cant_alavez) {
											$turnos = $this->turnos_model->selectCantidadxPuesto($fecha_turno, $hora_turno, $i);
											if(count($turnos)>0){
												$i++;
											}else{
												$puesto = $i;
												$i=($cant_alavez+1);
											}
										}
									}

									$result=$this->turnos_model->insert_turno($cuit,$fecha_turno,$hora_turno, $id_tarea,$id_gerencia,$id_delegacion,$observacion,$puesto);
									if($result!=false){
										$this->session->set_flashdata('id_turno',$result);
										$this->session->set_flashdata('gerencia',$data['gerencia']);
										$this->session->set_flashdata('delegacion',$data['delegacion']);
										if($data['fecha']!=null && $data['hora']!=null){
											$this->session->set_flashdata('fecha',$data['fecha']);
											$this->session->set_flashdata('hora',$data['hora']);
										}else{
											$this->session->set_flashdata('fecha',NULL);
											$this->session->set_flashdata('hora',NULL);
										}
										if($tienepuesto){
											$this->session->set_flashdata('puesto',$puesto);
										}else{
											$this->session->set_flashdata('puesto',NULL);
										}
										$this->session->set_flashdata('tarea',$data['tarea']);
										redirect('turnos/confirmarTurno');
									}else{
										$tipo="fail";
										$mensaje = "Ocurrio un error al registrar su turno";
										redirect("turnos/home");
									}
								}else{
									$tipo="fail";
									$mensaje = "El turno seleccionado <strong>YA NO ESTA DISPONIBLE</strong>, intente un horario distinto o recargue la página.".$cant_alavez." - ".count($turnos) ;
								}
							}else{
								$tipo="fail";
								$mensaje = "Ya tiene un turno pendiente para <strong>".$turnos[0]['id_tarea']."</strong> en la gerencia <strong>".$turnos[0]['id_gerencia']."</strong> de la delegación de <strong>".$turnos[0]['id_delegacion']."</strong>";
							}
					}else{
						$tipo="fail";
						$mensaje = "Ya tiene un turno pendiente en la gerencia <strong>".$turnos[0]['id_gerencia']."</strong> de la delegación de <strong>".$turnos[0]['id_delegacion']."</strong>";
					}
					}else{
						$tipo="fail";
						if($fecha_turno!=null && $hora_turno!=null){
							$mensaje = "Ya tiene un turno pendiente para el <strong>".$fecha_turno."</strong> a las <strong>".$hora_turno."</strong>";
						}else{
							$mensaje = "Ya tiene un turno pendiente sin asignar dia y horario";
						}

					}
				}else{
					$tipo="fail";
					$mensaje = "Tiene demasiados turnos EN ESPERA";
				}
				$this->toast($tipo,$mensaje);
				$this->load->view('turno_solicitud_view',$data);
			}
		}else{
			redirect('turnos/login');
		}

	}

	public function confirmarTurno(){
		$data['base_url']        = $this->config->base_url();
		$cuit = $this->session->userdata('username');
		$data['usuario'] = $this->usuario_model->select_usuario_byCuit($cuit);
		if($this->session->flashdata('id_turno')!=NULL){
			$data['id_turno']= $this->session->flashdata('id_turno');
			$data['gerencia']= $this->session->flashdata('gerencia');
			$data['delegacion']= $this->session->flashdata('delegacion');
			$data['fecha']= $this->session->flashdata('fecha');
			$data['hora']= $this->session->flashdata('hora');
			$data['tarea']=$this->session->flashdata('tarea');
			$data['puesto']=$this->session->flashdata('puesto');
		}else{
			redirect("turnos/home");
		}


		$this->load->view('turnos_confirmar_view',$data);
	}

	function comprobanteTurno($id){
		$data['base_url']        = $this->config->base_url();
		$data['turno']        = $this->turnos_model->select_turno_byID($id);
	  $this->load->view('cmp_view',$data);
	}

	public function update(){
		if($this->session->userdata('username')!=NULL){
			$cuit=$this->session->userdata('username');
			$localidad=$_POST['selectloc'];
			$calle=$_POST['calle'];
			$altura=$_POST['altura'];
			$dpto=$_POST['dpto'];
			$results=$this->usuario_model->update_usuario_dom($cuit, $localidad,$calle,$altura,$dpto);
			redirect('turnos/home');
		}
	}

	public function registrar(){
		$results = null;
		if($this->session->userdata('username')==NULL){
			$data['provincia']= $this->provincia_model->select_provincias();

			$data['base_url']        = $this->config->base_url();
			$this->load->view('turnos_registrarusuario_view', $data);
		}else{
			redirect('turnos/home');
		}

	}

	public function registrar_usuario(){
		$cuit = $this->input->post('cuit');
		$email=$this->input->post('email');
		$emailconfir=$this->input->post('emailconfir');
		//telefono
		$codArea=$this->input->post('codArea');
		$numero=$this->input->post('telefono');
		if($codArea!=null && $numero!=null){
			$telefono = "(".$codArea.") ".$numero;
		}else{
			$telefono=NULL;
		}
		//celular
		$codAreaC=$this->input->post('codAreaC');
		$numeroC=$this->input->post('celular');
		if($codAreaC!=null && $numeroC!=null){
			$celular = "(".$codAreaC.") 15".$numeroC;
		}else{
			$celular=NULL;
		}
		if($this->usuario_model->cuitValido($cuit)){
			if(!$this->empleado_model->empleadoExiste($cuit)){
				if(!$this->usuario_model->usuarioExiste($cuit)){
					if($emailconfir===$email){
						if(($telefono!=null) || ($celular!=null)){
							if (strlen($cuit) == 10){
									$documento='0'.substr($cuit, 2, 7);
							}else{
									$documento='0'.substr($cuit, 2, 8);
							}
							$ntramite=9999;
							$nombre=$this->input->post('nombre');
							$apellido=$this->input->post('apellido');
							$localidad=$this->input->post('selectloc');
							$calle=$this->input->post('calle');
							$altura=$this->input->post('altura');

							if($this->input->post('dpto')!=null){
								$dpto=$this->input->post('dpto');
							}else{
								$dpto=NULL;
							}

							if($this->input->post('email')!=null){
								$email=$this->input->post('email');
							}else{
								$email=NULL;
							}

							$results=$this->usuario_model->insert_usuario($cuit, $documento,$ntramite, $nombre, $apellido, $email, $telefono, $celular, $localidad,$calle,$altura,$dpto);
							if($results){
								die(json_encode(array('message' => '<div class="alert alert-success" role="alert">'.$nombre.' '.$apellido.' fue registrado exitosamente!</div>', 'code' => 'OK')));
							}else{
								die(json_encode('<div class="alert alert-danger" role="alert">Ocurrio un error al Ingresar el Usuario!</div>'));
							}
						}else{
							die(json_encode(array('message' => '<div class="alert alert-danger" role="alert">Debe ingresar al menos un número telefónico.</div>', 'code' => 'telefono')));
						}
					}else{
						die(json_encode(array('message' => '<div class="alert alert-danger" role="alert">Los campos de correo electronico no coinciden</div>', 'code' => 'correo')));
					}
				}else{
					die(json_encode(array('message' => '<div class="alert alert-danger" role="alert">El CUIT/CUIL '.$cuit.' pertenece a un usuario ya registrado</div>', 'code' => 'repetido')));
				}
			}else{
				die(json_encode(array('message' => '<div class="alert alert-danger" role="alert">El CUIT/CUIL '.$cuit.' pertenece a un Agente del Instituto</div>', 'code' => 'empleado')));
			}
		}else{
			die(json_encode(array('message' => '<div class="alert alert-danger" role="alert">El CUIT/CUIL '.$cuit.' es inválido</div>', 'code' => 'cuitinvalido')));
		}

	}

	public function consultaLocalidades(){
		$id=$_POST["idlocalidad"];
		$result=$this->localidad_model->select_localidades_byProvincia($id);

		$select = "<option value=''>Seleccionar</option>";
		for ($i=0; $i < count($result); $i++) {
				$select = $select.' <option value="' .$result[$i]['id_loc']. '">'.$result[$i]['nombre_loc']. '</option>';
		}
		echo $select;
	}

	public function toast($res,$mensaje){
		echo '<link rel="icon" href='.base_url().'"images/turnos/ico.png">';
		if (strcmp($res, "success") == 0) {
			print ('<div class="toast alert alert-success fixed-top-2" data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 0; right: 0;background:#D4EDDA;">


							<button type="button" class="ml-2 mb-1 close" data-bs-dismiss="toast" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>


							<div class="toast-body">
							'.$mensaje.'
							</div>
					</div>
				 ');
		} else {
			print ('<div class="toast alert alert-danger fixed-top-2" data-delay="5000" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 0; right: 0;background:#F8D7DA;">
							<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
							<div class="toast-body">
							'.$mensaje.'
							</div>
					</div>
				 ');
		}
	}
	public function consultaTareas(){
		$id=$_POST["iddelegacion"];
		if($id!=null){
		$detdelegacion = $this->delegacion_model->select_delegacion_byID($id);

		$result=$this->tareasxdelegacion_model->select_tareasxdelegacion_byDelegacion($id);
		$select='';
		//ordeno $result por gerencia => el array tiene id_tarea, id_delegacion, nombre_tarea, id_gerencia y nom_gerencia(de tarea)
		if($detdelegacion['direccion']!=NULL){
			$select = $detdelegacion['direccion'];
			$select = $select.$detdelegacion['mapa'];

		}

		$select = $select."<label for='tareas' class='text-info' >Seleccione el motivo o la tarea por la cual solicita el turno.</label><br>";
		$select = $select."<select  name='tareas'  id='tareas' class='form-control selectpicker' required onchange='CargarDias(this.value,selectdeleg.value);'>";
		$array_gerencia = array();
		foreach ($result as $keyGerencia=>$gerencia) {
			$id_gerencia[$keyGerencia] = $gerencia["id_gerencia"];
		}
		array_multisort($id_gerencia, SORT_ASC, $result);

		$dimesion_real=count($id_gerencia);
		$id_gerencia = array_unique($id_gerencia); //quita valores repetidos del array pero los deja en su posicion
																							//lo que hace que el array tenga huecos
		$pos = 0;
		for ($k=0; $k < $dimesion_real; $k++) {
			// elimino espacios vacios
			if(isset($id_gerencia[$k])){
				$array_gerencia[$pos] = $id_gerencia[$k];
				$pos++;
			}
		}

		$select = $select."<option value=''>Seleccione el motivo</option>";
		for ($j=0; $j < count($array_gerencia); $j++) {
			$select = $select.' <optgroup label="'.$this->gerencia_model->select_gerencia_byID($array_gerencia[$j])['nom_gerencia'].'">';
			for ($i=0; $i < count($result); $i++) {
				if($array_gerencia[$j]==$result[$i]['id_gerencia']){
					if($result[$i]['resaltar_tarea']){
						$select = $select.' <option style="background-color: #D97A78;color: white;font-weight: bold;" value="' .$result[$i]['id_tarea']. '">'.$result[$i]['nombre_tarea']. '</option>';
					}else{
						$select = $select.' <option  value="' .$result[$i]['id_tarea']. '">'.$result[$i]['nombre_tarea']. '</option>';
					}


				}
			}
			$select = $select .'</optgroup>';
		}
		$select = $select .'</select>';
	}else{

		$select = "<p>debe seleccionar una delegacion</p>";
		$this->listaDias();
	}
		echo $select;
	}

	public function listaDias(){




		$fecha = date('Y-m-j');

		$tarea = 1;//$_POST["tarea"];
		$delegacion = 2;//$_POST["delegacion"];
		$result = $this->tareasxdelegacion_model->select_tareasxdelegacion_byID($delegacion,$tarea);

		$tar =	$this->tareas_model->select_tarea_byID($tarea);

		$hora_inicio_atencion=$result['hora_inicio_atencion'];
		$hora_fin_atencion=$result['hora_fin_atencion'];
		$idgerencia=$tar['id_gerencia'];
		$fecha_limite = $result['fecha_limite'];

		$startdate = strtotime($hora_inicio_atencion);
    $enddate = strtotime($hora_fin_atencion);

		$rows_parametro = $this->parametros_model->select_parametros_byIDs($delegacion,$idgerencia);
		$intervalo = $rows_parametro['intervalo'];
		$turnosmismohorario = $rows_parametro['turnosmismohorario'];
		$select ='';

		if($result['privacidad']=='PUBLICO'){


			$count = 10;
			$i=1;
			if(date('l', strtotime ( $fecha ))=='Saturday'){
				 $i=3;
			}if(date('l', strtotime ( $fecha ))=='Sunday'){
				$i=2;
			}

			$horareal = strtotime ( date('h:i:s A') );
			if($horareal>=strtotime('12:15:00 PM')){ //PUEDE VARIAR ESTA HORA CUANDO FINALICE EL PERIODO DE CUARENTENA
				if(date('l', strtotime ( $fecha ))=='Friday'){
					 $i=4;
				}else {
					$i=2;
				}
			}
			$disponible=FALSE;



			//arma los dias que no se puede sacar turno

			if($result['fecha_limite']!=NULL){
	      $count= (strtotime($result['fecha_limite'])-strtotime($fecha))/86400;
	    }
			$disponible = $this->turnos_model->comprobarDisponibilidad($i,$count, $delegacion, $idgerencia, $tarea);
			$diasnolaborables = $this->getDiasNoLaborales();
			$fechas = "[";
			foreach ($diasnolaborables as $dnl){
				$fechas .=' ['.date('m, d', strtotime($dnl['fecha'])).'],';
			}
			$fechas .= $disponible.']';

			if (strpos($fechas, "],1]") === false){
				$select = "<div class='alert alert-danger'>YA NO HAY TURNOS DISPONIBLES PARA LA TAREA SELECCIONADA.</div>";
			}else{

				$select = "<label for='dia' class='text-info'  >Seleccione el dia del turno solicitado </br> (En el calendario solo podrá seleccionar los dias que aun tienen turnos disponibles).</label></br>";
				$fechas = str_replace("],]", "]]", $fechas);



				$select = $select."<input type='text' class='form-control' placeholder='Seleccione un día' onchange='CargarHoras(this.value,tareas.value,selectdeleg.value);' id='calendario' onkeydown='return false' readonly name='calendario'>";
				$select = $select."<script type='text/javascript'>";
				$select = $select."	$(function() {";
				$select = $select."		$('#calendario').datepicker({";
				$select = $select."			minDate: '".$i."',";
				$select = $select."			maxDate: '".$count."',";
				$select = $select."			beforeShowDay: noWeekendsOrHolidays,";
				$select = $select."		});";
				$select = $select."		diasnolaborales = ".$fechas.";";
				$select = $select."		function nationalDays(date) {";
				$select = $select."			for (i = 0; i < diasnolaborales.length; i++) {";
				$select = $select."				if (date.getMonth() == diasnolaborales[i][0] - 1 && date.getDate() == diasnolaborales[i][1]) {";
				$select = $select."					return [false, diasnolaborales[i][2] + '_day'];";
				$select = $select."				}";
				$select = $select."			}";
				$select = $select."			return [true, ''];";
				$select = $select."		}";
				$select = $select."		function noWeekendsOrHolidays(date) {";
				$select = $select."			var noWeekend = $.datepicker.noWeekends(date);";
				$select = $select."			if (noWeekend[0]) {";
				$select = $select."				return nationalDays(date);";
				$select = $select."			} else {";
				$select = $select."				return noWeekend;";
				$select = $select."			}";
				$select = $select."		}";
				$select = $select."	});";
				$select = $select."</script>";

				$select = $select."<div class='form-group'>";
				$select = $select."<label for='horarioselect' class='text-info'>Seleccione un horario de atencion para el dia seleccionado.</label><br>";
				$select = $select."<select disabled name='horarioselect' id='horarioselect' class='form-control' onchange='CargarArea(this.value,tareas.value,selectdeleg.value)' required>";
				$select = $select."<option value='' >Seleccione el horario</option>";
				$select = $select."</select>";
				$select = $select."</div>";
				$select = $select."<div class='form-group' id='personalidado' name='personalidado'>";
				$select = $select."</div>";
			}

		}else{
			//consulta disponibilidad de tareas
			if($result['privacidad']=='PRIVADO'){
				$cantidad = $this->turnos_model->select_cant_turnos_pendientes($delegacion,$tarea);
				$t = $this->tareas_model->select_tarea_byID($tarea);
				$rows_parametro = $this->parametros_model->select_parametros_byIDs($delegacion,$t['id_gerencia']);

				if($cantidad['cantidad']>=$rows_parametro['cantDiarios']){
					$select = "<div class='alert alert-danger intermitente'>Por el momento no hay disponibilidad de turnos. Disculpe las molestias ocasionadas</div>";
				}else{
					$select = "<label class='text-info'>Ingrese EL MOTIVO POR EL DESEA UN TURNO *</label>";
					$select = $select."<textarea id='observacion' name='observacion' class='form-control' rows='3' placeholder='Escriba brevemente el motivo de su turno. Recuerde que este permitirá a nuestros agentes ayudarlo.' required maxlength='150' onkeyup='countChars(this);'></textarea>";
					$select = $select."<p id='charNum'>150 caracteres restantes</p>";
				}
			}


		}
		echo $select;
	}

	public function getDiasNoLaborales(){
		$diasnolaborables=$this->diasnolaborables_model->select_diasnolaborables();

		return $diasnolaborables;
	}
	public function seccionPersonalizada(){
		$tarea = $_POST["tarea"];
		$delegacion = $_POST["delegacion"];

		$t=$this->tareas_model->select_tarea_byID($tarea);
		if($tarea==28){
			$select = "<input type='hidden' name='campooblig' id='campooblig'  value='Solicita turno por Ayuda con DDJJ'></br>";

			$select = $select."<div class='alert alert-warning' role='alert'>";
			$select = $select."<H3>Antes de solicitar un turno <br/>Comuníquese con nuestro CALL CENTER</h3>";
			$select = $select."<H4 class='text-danger'><svg width='32' height='32' fill='currentColor' class='bi bi-telephone-fill' viewBox='0 0 16 16'>";
			$select = $select."<path fill-rule='evenodd' d='M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z'/>";
			$select = $select."</svg>";
			$select = $select."(2954) 424513<br/></H4>";
			$select = $select."<h4 class='text-info'>Internos 5191 - 5192 - 5193 - 5194 - 5495.</h4>";
			$select = $select."</div>";
			$select = $select."<div class='alert alert-danger' role='alert'>
			<div class='form-check'>
      <input class='form-check-input' type='checkbox' id='myCheck' onchange='activaBoton(this.value)' required>
      <label class='form-check-label' for='myCheck'>
        Ya me comuniqué y no pude solucionar mi problema. Deseo solicitar un turno.
      </label>
    </div>
			</div>";
		}else{
			$select = "<label class='text-info'>Ingrese UNA NOTA PARA SU TURNO *</label>";
			$select = $select."<textarea id='campooblig' name='campooblig' class='form-control' rows='3' placeholder='Escriba brevemente una descripción del trámite que desea realizar.' required maxlength='150' onkeyup='countChars(this);'></textarea>";
			$select = $select."<p id='charNum'>150 caracteres restantes</p>";
			$select = $select."<div class='alert alert-warning' role='alert'>
				<div class='form-check'>
		      <input class='form-check-input' type='checkbox' id='myCheck' onchange='activaBoton(this.value)'  required>
		      <label class='form-check-label' for='myCheck'>
		        Confirmo que el turno que estoy a punto de solicitar corresponde al motivo que seleccioné
		      </label>
	 		 	</div>
			</div>";
		}

		echo $select;

	}
	public function formatoFecha($fecha_turno){
		$auxiliar=date('l j \of F Y',$fecha_turno);
		//Dias
		$auxiliar=str_replace('Monday','Lunes',$auxiliar);
		$auxiliar=str_replace('Tuesday','Martes',$auxiliar);
		$auxiliar=str_replace('Wednesday','Miercoles',$auxiliar);
		$auxiliar=str_replace('Thursday','Jueves',$auxiliar);
		$auxiliar=str_replace('Friday','Viernes',$auxiliar);
		//Meses
		$auxiliar=str_replace('January','Enero',$auxiliar);
		$auxiliar=str_replace('February','Febrero',$auxiliar);
		$auxiliar=str_replace('March','Marzo',$auxiliar);
		$auxiliar=str_replace('April','Abril',$auxiliar);
		$auxiliar=str_replace('May','Mayo',$auxiliar);
		$auxiliar=str_replace('June','Junio',$auxiliar);
		$auxiliar=str_replace('July','Julio',$auxiliar);
		$auxiliar=str_replace('August','Agosto',$auxiliar);
		$auxiliar=str_replace('September','Septiembre',$auxiliar);
		$auxiliar=str_replace('October','Octubre',$auxiliar);
		$auxiliar=str_replace('November','Noviembre',$auxiliar);
		$auxiliar=str_replace('December','Diciembre',$auxiliar);
		$auxiliar=str_replace(' of ',' de ',$auxiliar);

		return $auxiliar;
	}

	public function listaHorarioDisponible(){

		$fecha = $_POST["dia"];
    $iddelegacion = $_POST["delegacion"];
    $idtarea = $_POST["tarea"];
		$rows_tareas = $this->tareas_model->select_tarea_byID($idtarea);
		$idgerencia=$rows_tareas['id_gerencia'];
		$row_tareaxdel = $this->tareasxdelegacion_model->select_tareasxdelegacion_ymas($iddelegacion, $idgerencia, $idtarea);

		$intervalo = $row_tareaxdel['intervalo'];
		$turnosmismohorario = $row_tareaxdel['turnosmismohorario'];
		$startdate = strtotime($row_tareaxdel['hora_inicio_atencion']);
    $enddate = strtotime($row_tareaxdel['hora_fin_atencion']);

		$cant =0;
		while ($startdate <= $enddate){
			$row_turno = $this->turnos_model->select_turno_byFHDG(date('Y-m-d',strtotime ($fecha)),date("H:i:s", $startdate),$iddelegacion,$idgerencia);
			if (count($row_turno) < $turnosmismohorario){
				$cant++;
				$select = $select." <option value='" . date("H:i:s", $startdate) . "'>" . date("h:i A", $startdate) . " </option>";
			}
			$startdate = strtotime("+$intervalo minutes", $startdate);
		}
		if($cant>0){
			$encabezado = ' <option value="">Seleccione el horario</option>';
		}else{
			$encabezado = ' <option value="">Ya no hay horarios disponibles para este día</option>';
		}
		$select = $encabezado." ".$select;
		echo $select;
	}


}
?>
