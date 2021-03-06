<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Inicio</title>

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
		<style type="text/css">
			.atendido {
				background-color: #82AF6F;
			}
			.pendiente {
				background-color: #FEE188;	
			}
			.ausente {
				background-color: #D15B47;	
			}	
		</style>
	</head>
<?php include('personas-funciones.php');?>
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
					<a href="index.php" class="navbar-brand">
						<small>
							<img class="nav-user-photo" src="../assets/images/avatars/doctor-calendar2.png"/>
							TurnoMedic
						</small>
					</a>
				</div>
				
				<!--NOMBRE DE USUARIO-->
				<div class="navbar-header pull-right" role="navigation">
					<img class="nav-user-photo" src="../assets/images/avatars/paciente.png"/>
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
				
				<!--MENU PRINCIPAL-->
				<ul class="nav nav-list">

					<!--MENU TURNOS DEL DIA-->
					<li class="active">
						<a href="index.php">
							<i class="menu-icon glyphicon glyphicon-time"></i>
							<span class="menu-text"> Mis Turnos </span>
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
								<a href="index.php">Inicio</a>

							</li>

							<!--<li>
								<a href="#">Other Pages</a>
							</li>-->

							<li class="active">Mis Turnos</li>
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

						<div class="row">						
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="col-sm-9">
										<div class="space"></div>
										<div style="text-align: center; font-size: 22px;"><?php echo date('d/m/Y'); ?></div>
										<div class="table-responsive-sm" >

										<table class="table table-bordered table-hover" style="text-align:center">
										<tr>
											<th class="center scope="col"><img src="../assets/images/avatars/reloj.png"/></th>
											<th class="center scope="col">Estado</th>
											<th class="center scope="col">Tipo de Turno</th>
											<th class="center scope="col">Paciente</th>
											<th class="center scope="col">Acciones</th>
										</tr>
										<?php cargarTurnosparaHoy(); ?>
										</table>
									</div>
										<div id="calendar"></div>
									</div>

									<div class="col-sm-3">
										<div class="widget-box transparent">
											<div class="widget-header">
												<h4>Estado del Turno</h4>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<div id="external-events">

														<div class="external-event label-success" data-class="label-success" align="center">
															 Atendido
														</div>

														<div class="external-event label-yellow" data-class="label-yellow" align="center">
															Pendiente
														</div>

														<div class="external-event label-danger" data-class="label-danger" align="center">								
															Ausente
														</div>
													</div>
												</div>
											</div>
										</div>
								
								<!-- PAGE CONTENT ENDS -->
									</div><!-- /.col -->
								</div><!-- /.row -->
							</div><!-- /.page-content -->
						</div>
				</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">TurnoMedic</span>
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

			function operacion(tipo, idturno) {
				var mensaje ="";
				if(tipo == 1) {
					mensaje = "¿Marcar el turno Nº "+idturno+" como atendido?";
				} else if(tipo == 2) {
					mensaje = "¿Marcar el turno Nº "+idturno+" como ausente?";
				} else {
					mensaje = "¿Cancelar el turno Nº "+idturno+" ?";
				}
				if (confirm(mensaje)) {
					top.window.location.href='gestion-turno.php?idturno='+idturno+'&operacion='+tipo;
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
