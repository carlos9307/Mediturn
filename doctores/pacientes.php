<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Pacientes</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="../assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="../assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="../assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="../assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="../assets/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="../assets/js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>
<?php 
include('personas-funciones.php');
/*$consulta = "SELECT ID_PERSONA, APELLIDO, PERSONAS.NOMBRE AS NOMBRE, FECHA_NAC, DNI, DIRECCION.DESCRIPCION, RELA_LOCALIDAD, LOCALIDAD.NOMBRE AS LOCALIDAD, O"
consulta($);*/
 ?>
	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default          ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="index.html" class="navbar-brand">
						<small>
							<i class="fa fa-calendar"></i>
							TurnoMedic
						</small>
					</a>
				</div>
				
				<!--NOMBRE DE USUARIO-->
				<div class="navbar-header pull-right" role="navigation">
					<img class="nav-user-photo" src="../assets/images/avatars/doctor.png"/>
					<span class="white">Bienvenido, </span>
					<span class="white">NOMBRE USUARIO</span>
				</div>

			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<!--ACCESOS DIRECTOS-->
				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon glyphicon glyphicon-user"></i>
						</button>

						<button class="btn btn-info">
							<i class="ace-icon glyphicon glyphicon-remove"></i>
						</button>

						<button class="btn btn-warning">
							<i class="ace-icon glyphicon glyphicon-ok"></i>
						</button>

						<button class="btn btn-danger">
							<i class="ace-icon glyphicon glyphicon-log-out"></i>
						</button>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->

				
				<!--MENU PRINCIPAL-->
				<ul class="nav nav-list">

					<!--MENU TURNOS DEL DIA-->
					<li class="">
						<a href="index.html">
							<i class="menu-icon glyphicon glyphicon-time"></i>
							<span class="menu-text"> Turnos del Dia </span>
						</a>

						<b class="arrow"></b>
					</li>

					<!-- MENU TURNOS-->
					<li class="">
						<a href="turnos-disponibles.html">
							<i class="menu-icon fa fa-calendar"></i>
							<span class="menu-text"> Turnos Disponibles </span>

							<b class="arrow"></b>
						</a>
					</li>

					<!--MENU PACIENTES-->

					<li class="active">
						<a href="pacientes.php">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> Pacientes </span>
						</a>

						<b class="arrow"></b>
					</li>
					<!--<li class="active open">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> Pacientes </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="pacientes.html">
									<i class="menu-icon fa fa-caret-right"></i>
									Agregar Paciente
								</a>

								<b class="arrow"></b>
							</li>

							<li class="active">
								<a href="pacientes-buscar.html">
									<i class="menu-icon fa fa-caret-right"></i>
									Buscar Paciente
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>-->


					
					<!--MENU REPORTES-->
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon glyphicon glyphicon-print "></i>
							<span class="menu-text"> Reportes </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="#">
									<i class="menu-icon fa fa-caret-right"></i>
									Reporte 1
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="#">
									<i class="menu-icon fa fa-caret-right"></i>
									Reporte 2
								</a>

								<b class="arrow"></b>
							</li>

						</ul>
					</li>
					
					<!--MENU ADMINISTRACION-->
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa  fa-cogs"></i>
							<span class="menu-text">
								Configuracion
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="#" class="dropdown-toggle">
									<i class="menu-icon fa fa-caret-right"></i>

									Parametros
									<b class="arrow fa fa-angle-down"></b>
								</a>

								<b class="arrow"></b>

								<ul class="submenu">
									<li class="">
										<a href="#">
											<i class="menu-icon fa fa-caret-right"></i>
											Feriados
										</a>

										<b class="arrow"></b>
									</li>

									<li class="">
										<a href="#">
											<i class="menu-icon fa fa-caret-right"></i>
											Horarios
										</a>

										<b class="arrow"></b>
									</li>

									<li class="">
										<a href="#">
											<i class="menu-icon fa fa-caret-right"></i>
											Turnos Fijos
										</a>

										<b class="arrow"></b>
									</li>

								</ul>
							</li>


							<li class="">
								<a href="#" class="dropdown-toggle">
									<i class="menu-icon fa fa-caret-right"></i>

									Seguridad
									<b class="arrow fa fa-angle-down"></b>
								</a>

								<b class="arrow"></b>

								<ul class="submenu">
									<li class="">
										<a href="#">
											<i class="menu-icon fa fa-caret-right"></i>
											Usuarios
										</a>

										<b class="arrow"></b>
									</li>

									<!--<li class="">
										<a href="#" class="dropdown-toggle">
											Backups
											<b class="arrow fa fa-angle-down"></b>
										</a>

										<b class="arrow"></b>

										<ul class="submenu">
											<li class="">
												<a href="#">
													<i class="menu-icon fa fa-caret-right"></i>
													Realizar Backup
												</a>

												<b class="arrow"></b>
											</li>

											<li class="">
												<a href="#">
													<i class="menu-icon fa fa-caret-right"></i>
													Restaurar BD
												</a>

												<b class="arrow"></b>
											</li>
										</ul>
									</li>-->

								</ul>
							</li>
						</ul>
					</li>
					
					<!--MENU AYUDA-->
					<li class="">
						<a href="#">
							<i class="menu-icon fa fa-info-circle"></i>
							<span class="menu-text"> Ayuda </span>
						</a>

						<b class="arrow"></b>
					</li>
				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="index.html">Inicio</a>

							</li>

							<!--<li>
								<a href="#">Pacientes</a>
							</li>-->

							<li class="active">Pacientes</li>
						</ul><!-- /.breadcrumb -->
					</div>

					<div class="page-content">
						<div class="ace-settings-container" id="ace-settings-container">
							<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
								<i class="ace-icon fa fa-cog bigger-130"></i>
							</div>

							<div class="ace-settings-box clearfix" id="ace-settings-box">
								<div class="pull-left width-50">
									<div class="ace-settings-item">
										<div class="pull-left">
											<select id="skin-colorpicker" class="hide">
												<option data-skin="no-skin" value="#438EB9">#438EB9</option>
												<option data-skin="skin-1" value="#222A2D">#222A2D</option>
												<option data-skin="skin-2" value="#C6487E">#C6487E</option>
												<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
											</select>
										</div>
										<span>&nbsp; Elegir Skin</span>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-add-container" autocomplete="off" />
										<label class="lbl" for="ace-settings-add-container">
											Compactar Vista
										</label>
									</div>
								</div><!-- /.pull-left -->
						
							</div><!-- /.ace-settings-box -->
						</div><!-- /.ace-settings-container -->
					
						<div class="page-header">
							<h1>
								Pacientes
							</h1>
						</div><!-- /.page-header -->


						<div class="row">
							<div class="col-xs-12">

									<!-- PAGE CONTENT BEGINS -->

								<div class="widget-body">
												<div class="widget-main">
												
													<form class="form-search">
														<div class="row">
															<div class="col-xs-12 col-sm-9">
																<div class="input-group">
																	<span class="input-group-addon">
																		<i class="ace-icon fa fa-check"></i>
																	</span>

																	<input type="text" class="form-control search-query" placeholder="" id="cajaBuscar"/>
																	<span class="input-group-btn">
																		<a href="#" class="btn btn-purple btn-sm"  onclick="mandarFormGet('pacientes.php');"> <i class="ace-icon fa fa-search icon-on-right bigger-110"></i> Aceptar</a>
																	</span>
																</div>	

															</div>	
																														
														 </div>
													 	
													</form>
													

													<div class="control-group">

															<!--<label class="control-label bolder blue">Buscar por:</label>-->
															<div class="radio">
																<label>
																	<input name="form-field-radio" type="radio" class="ace" value="apyn" checked />
																	<span class="lbl"> Apellido y Nombre</span>
																</label>
															</div>

															<div class="radio">
																<label>
																	<input name="form-field-radio" type="radio" class="ace" value="dni" />
																	<span class="lbl"> DNI</span>
																</label>
															</div>

													</div>

												</div>

												<div class="hr"></div>

									
									<div width="100%" class="table-responsive-sm ">


										<table class="table  table-bordered table-hover">
											<thead>
											    <tr>
											      <th  class="center scope="col">N°</th>
											      <th  class="center scope="col">Apellido</th>
											      <th  class="center scope="col">Nombre</th>
											      <th  class="center scope="col">DNI</th>
											      <th  class="center scope="col">Fecha de Nacimiento</th>
											      <th  class="center scope="col">Accion</th>										   
											    </tr>
											  </thead>
											  <tbody>
											  	<?php 
											  		if (isset($_GET['buscar'])) {
											  			$claveBuscar = $_GET['buscar'];
											  			$criterio = $_GET['criterio'];
											  		} else {
											  			$claveBuscar = "";
											  			$criterio = "";
											  		}
											  		cargarTablaPacientes($claveBuscar, $criterio);
											  	?>
											    
											</tbody>
										</table>
		
									</div>

									

									<div class="center">

										<a href="pacientes-agregar.html" class="btn btn-sm btn-primary"> <i class="ace-icon glyphicon glyphicon-plus"></i>Agregar</a>

										<!--<a href="pacientes-agregar.html" class="btn btn-sm btn-info"> <i class="ace-icon glyphicon glyphicon-list"></i>Ver Detalle</a>

										<a href="pacientes-agregar.html" class="btn btn-sm btn-warning"> <i class="ace-icon glyphicon glyphicon-ok"></i>Asignar Turno</a>-->

										<a href="pacientes-agregar.html" class="btn btn-sm btn-success"> <i class="ace-icon glyphicon glyphicon-check"></i>Ver Turnos</a>

									</div>
								
									<!-- PAGE CONTENT ENDS -->
								</div><!-- /.col -->

							
							</div><!-- /.row -->

				</div><!-- /.page-content -->


			</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">Nombre Aplicacion</span>
							V.1.0 &copy; 2018 
						</span>

						
					</div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="../assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='../assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
			
			/*document.getElementsByName('IdRegistro').addEventListener('click',function(e){
  				e.preventDefault();
  				var eliminar = confirm("Desea eliminar el registro del paciente?");
  				if (eliminar == true) {
  					top.window.href = "actualizar.php?id="
  				}
				}); */

			function mandarFormGet(url) {
				var buscado = document.getElementById('cajaBuscar').value;
				var criterio = capturarRadio("form-field-radio");
				if (buscado !="") {
					top.window.location.href= url+'?buscar='+buscado+'&criterio='+criterio;
				} else {
					top.window.location.href= url;
				}
			}

			function capturarRadio(radiobutton) {
				var valoresRadio = document.getElementsByName(radiobutton);
				for(var i = 0; i < valoresRadio.length; i++) {
					if(valoresRadio[i].checked) {
						return valoresRadio[i].value;
					}
				}
			}
		</script>
		<script src="../assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!-- ace scripts -->
		<script src="../assets/js/ace-elements.min.js"></script>
		<script src="../assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
	</body>
</html>
