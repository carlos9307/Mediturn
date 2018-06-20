<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<script type="text/javascript" src="../assets/js/date.js" ></script>
	
	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="../assets/font-awesome/4.5.0/css/font-awesome.min.css" />
		<!-- text fonts -->
	<link rel="stylesheet" href="../assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
	<link rel="stylesheet" href="../assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
	<link rel="stylesheet" href="../assets/css/ace-skins.min.css" />
	<link rel="stylesheet" href="../assets/css/ace-rtl.min.css" />


	<script type="text/javascript" src="/assets/js/jquery.js"></script>
	<style type="text/css">
		.ocupado {
			background-color: #e06b5e;
		}

		.disponible {
			background-color: #f9ee66;
		}

		.libre {
			background-color: #5ed18e;
		}
		.cerrado {
			background-color: #d6d7d8;
		}
		.fecha-fixture {
			text-align: center;
			font-size: 20px;
			font-weight: bold;
		}
	</style>
</head>
<body>
<?php 
include("calendario-funciones.php");
 $fechaSeleccionada = mostrarFecha();
 $GLOBALS['FECHASEL'] = $fechaSeleccionada;
function mostrarFecha() {//Funcion para mostrar la fecha
	if (isset($_GET['year']) && isset($_GET['mes']) && isset($_GET['dia'])) {	//Si se selecciono una fecha
		
		//Armo la fecha en el formato YYYY-mm-dd porque la funcion lo usa asi
		$year = $_GET['year'];
		$mes = "0".(intval($_GET['mes']) + 1);
		$dia = $_GET['dia'];
		$fechaSel = $year."-".$mes."-".$dia;
		$fechaModoNormie = date("d/m/Y", strtotime($fechaSel)); //le doy el formato normal dd/mm/YYYY
		$fechaSeleccionada = date("Y-m-d", strtotime($fechaSel)); 	//Aca fijo la fecha que se va a procesar
		echo "<div class='fecha-fixture'>".corregirAcento(sacarDia($fechaSel)).", ".$fechaModoNormie."</div>"; //Mostrar fecha en titulo
	
	} elseif(isset($_POST['patologias'])) {	//Si se selecciono solo una patologia, no cambiamos la fecha
		echo "<div class='fecha-fixture'>".corregirAcento(sacarDia($_POST['fechaAnterior'])).", ".date("d/m/Y", strtotime($_POST['fechaAnterior']))."</div>"; //Mostrar fecha en titulo
		return $_POST['fechaAnterior'];
	} else {//Si no se selecciona fecha
		$fechaSel = date("d/m/Y");	//agarro la fecha de hoy
		$fechaSeleccionada = date("Y-m-d");
		echo "<div class='fecha-fixture'>".corregirAcento(sacarDia($fechaSeleccionada)).", ".$fechaSel."</div>"; //Mostrar fecha de hoy en titulo
	}
	return $fechaSeleccionada;
	
}


function armarTabla($horarios, $horarioActual) {
//Funcion que arma la tabla
	foreach($horarios as $hora) { //Se recorre el array de horarios
		echo "<tr><td>".$hora."</td>";
		$vacio = true;
		if(isset($_POST['patologias']) && cupoPatologia($_POST['patologias'], $GLOBALS['FECHASEL'])== false) {
			if($GLOBALS['perfil'] == 'Profesional') {
				$gCant = 0;
			} else {
				$gCant = "No";
			}
			echo "<td class='ocupado'>Ocupado</td>", "<td class='ocupado'>".$gCant."</td>", "<td class='ocupado'>".$gCant."</td>",
			"<td class='ocupado'>-</td>";
			continue; }
		foreach ($horarioActual as $registro=>$estado) {	//Se recorre el array de turnos del dia
			
			if (isset($_POST['patologias']) && $_POST['patologias'] != $estado['patologia']) { continue; }
			
			if ($hora == date("H:i", strtotime($estado['HORA_TURNO']))) {	//Si el turno coincide con el horario
				
				$vacio = false;
				$cupos = obtenerCuposTurno($estado['FECHA_TURNO'], $hora); //guardo cantidad de cupos por hora y fecha dadas
				$cantCamillas = 0;
				$cantGimnasio = 0;
				foreach($cupos as $reg=>$camp) {	//en este for asigno las cantidades para cada categoria
					if($camp['sesion'] == "Camilla") {
						$cantCamillas += $camp['cantidad'];
					} elseif($camp['sesion'] =="Gimnasio") {
						$cantGimnasio += $camp['cantidad'];
					}
				}
				
				$disponibilidad = estadoTurno($cantCamillas, $cantGimnasio);


				if ($disponibilidad == "Disponible") { //If que determina los colores de las casillas
					$colorCasilla = "disponible";
				} elseif($disponibilidad == "Libre") {
					$colorCasilla = "libre";
				} elseif($disponibilidad == "Ocupado") {
					$colorCasilla = "ocupado";
				}

				echo "<td class=".$colorCasilla.">".$disponibilidad."</td>";	//Cargo la disponibilidad

				//Cargo los cupos disponibles
				echo "<td class=".$colorCasilla.">".cantidadCupos($cantCamillas, $GLOBALS['MaximoCamillas'])."</td>",
				"<td class=".$colorCasilla.">".cantidadCupos($cantGimnasio, $GLOBALS['MaximoGimnasio'])."</td>";
				
				//Cargo el boton reservar si es que esta disponible
				echo "<td>";
				if ($disponibilidad == "Disponible") { 
					echo "<input type='button' value='Si' onclick='location=\"reservar.php?fecha=".$GLOBALS['FECHASEL']."&hora=".$hora."\";'/>";
				} else {
					echo "-";
				}
				echo "</td>";
			}
		}
		if ($vacio == true) { //Si en el horario no cayo ningun turno entonces...
			echo "<td class='libre'>Libre</td>"; 
			if ($GLOBALS['perfil'] == "profesional") {
				echo "<td class='libre'>".$GLOBALS['MaximoCamillas']."</td>", "<td class='libre'>".$GLOBALS['MaximoGimnasio']."</td>";
			} else {
				echo "<td class='libre'>Si</td>", "<td class='libre'>Si</td>"; 
			} 
			echo "<td><input type='button' value='Si' onclick='location=\"reservar.php?fecha=".$GLOBALS['FECHASEL']."&hora=".$hora."\";'/></td>";
		}
		echo "</tr>";
	}
}

function obtenerCantidadCupos($hora, $matriz, $tipo) {
	$contador = 0;
	foreach($matriz as $registro=>$campo) {
		if($campo['sesion'] == $tipo && $campo['HORA_TURNO'] == $hora) {
			$contador+= $campo['cantidad'];
		}
	}
	return $contador;
}
?>
<!--
<script>
		$(function () {

		$("#especialidades").click(function() {

		var url = "agenda-dia.php";

		$.ajax({
		type: "POST",
		url: url,
		data: $("#formulario").serialize(),
		success: function(data)
		{
			$("#direccion").html(data);
		}
		});

		return false;

		});

		});

</script> -->

<form>
	<input type="button" value="Ver Mes" / onclick="location='calendario.html';" />
	<input type="button" value="Ver Semana" onclick="location='agenda-semana.php';"/>
	<input type="button" value="Ver Dia" onclick="location='agenda-dia.php';"/>
</form>
<form class="formulario" action="agenda-dia.php" method="post">
	<?php
		comboEspecialidades();
		comboPatologias();
	?>

	<input type="submit" value="Filtrar" />
	<input type="hidden" value=<?php echo "'".$fechaSeleccionada."'"; ?> name="fechaAnterior" />
	<div class="table-responsive-sm" >

		<table class="table table-bordered table-hover" style="text-align:center">
			<tr>
				<th class="center scope="col"><img src="../assets/images/avatars/reloj.png"/></th>
				<th class="center scope="col">Estado</th>
				<th class="center scope="col"><img src="../assets/images/avatars/camilla.png"/></th>
				<th class="center scope="col"><img src="../assets/images/avatars/gim.png"/></th>
				<th class="center scope="col"><img src="../assets/images/avatars/reservar.png"/></th>
			</tr>
			<?php
				$horarioActual = consultarTurnosDia($fechaSeleccionada); //Guardo la matriz de turnos de la fecha dada
				$horarioDia = armarHorarioDia($fechaSeleccionada); //Guardo la matriz de horarios de la jornada del dia
				
				if($horarioDia[0] != "Sin horarios") {	//Si hay horarios cargados
					armarTabla($horarioDia, $horarioActual);
				} else {
					//Si no hay horarios cargados, no es un dia laborable
					echo "<td class='cerrado' colspan=5>Dia sin horarios laborales</td>";
				}
			?>
		</table>
	</div>

</form>
</body>
</html>
