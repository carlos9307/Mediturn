<?php
include('personas-funciones.php');
if(isset($_GET['fecha']) && isset($_GET['hora'])) { //Guardo la fecha y la hora en un session
    $_SESSION['fechaTurno'] = $_GET['fecha'];
    $_SESSION['horaTurno'] = $_GET['hora'];
}
?>
<!DOCTYPE <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reservar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <style type="text/css">
            #buscarPersona {
                width: 800px;
            }
            #pacienteSelec {
                padding-left: 5px;
                padding-right: 5px;
                color: #000000;
                font-weight: bold;
            }
        </style>
</head>
<body>
<div id="buscarPersona" style="">
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
                                <a href="#" class="btn btn-purple btn-sm"  onclick="mandarFormGet('reservar.php');"> <i class="ace-icon fa fa-search icon-on-right bigger-110"></i> Aceptar</a>
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
    </div>
<div width="100%" class="table-responsive-sm ">


	<table class="table  table-bordered table-hover">
		<thead>
	        <tr>
				<th  class="center scope="col">N°</th>
				<th  class="center scope="col">Apellido</th>
				<th  class="center scope="col">Nombre</th>
				<th  class="center scope="col">DNI</th>
		        <th  class="center scope="col">Fecha de Nacimiento</th>									   
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
</div>
    <form action="" method="post">
        Paciente <label id="pacienteSelec" name="pacienteSelec" value=""></label><input type="button" value="Buscar" onclick="mostrar('buscarPersona');" />
        <input type="hidden" value="" id="idpersona" name="idpersona"/> 
    </form>
    <script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='../assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
			
			/*document.getElementsByName('IdRegistro').addEventListener('click',function(e){
  				e.preventDefault();
  				var eliminar = confirm("Desea eliminar el registro del paciente?");
  				if (eliminar == true) {
  					window.href = "actualizar.php?id="
  				}
				}); */

			function mandarFormGet(url) {
				var buscado = document.getElementById('cajaBuscar').value;
				var criterio = capturarRadio("form-field-radio");
				if (buscado !="") {
					window.location.href= url+'?buscar='+buscado+'&criterio='+criterio;
				} else {
			        window.location.href= url;
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
            
            function mostrar(elemento){
			    document.getElementById(elemento).style.display = 'block';
		    }

		    function ocultar(elemento){
			    document.getElementById(elemento).style.display = 'none';
            }

            function cargarPersona(id, nombre) {
                document.getElementById("pacienteSelec").value = nombre;
                document.getElementById("pacienteSelec").innerHTML = nombre;
                document.getElementById("idpersona").value = id;
                ocultar("buscarPersona");
            }

            <?php 
            if (isset($_GET['buscar'])) {
                echo "var buscando =  ".$_GET['buscar'].";";
            } else {
                echo "var buscando =  'no';";
            }
            ?>
            if(buscando != "no") {
                mostrar("buscarPersona");
            } else {
                ocultar("buscarPersona");
            }
		</script>
</body>
</html>