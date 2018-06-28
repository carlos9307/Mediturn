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
<?php
include("calendario-funciones.php");
$matrizSemana = determinarSemana(date('Y-m-d'));

$horarios = array("07:00", "07:30", "08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30", "20:00", "20:30", "21:00", "21:30", "22:00", "22:30", "23:00", "23:30");

function armarSemana($horarios, $horarioActual, $dias) {
//Funcion que arma la tabla	
	foreach($horarios as $hora) { //Se recorre el array de horarios
		echo "<tr><td>".$hora."</td>";
		foreach($dias as $dia=>$fecha) {
			$vacio = true;
			if($dia != "Domingo") {
				foreach ($horarioActual as $campo=>$estado) {	//Se recorre el array de turnos del dia
					if (isset($_POST['patologias']) && $_POST['patologias'] != $estado['patologia']) { continue; }
					if ($hora == date("H:i", strtotime($estado['HORA_TURNO'])) && date("w", strtotime($estado['FECHA_TURNO'])) == date("w", strtotime($fecha))) {	//Si el turno coincide con el horario y el dia
						if (verificarLaborable($hora, $dia) == true) {
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
									

							/*if ($GLOBALS['perfil'] == "profesional") { //si el perfil es de profesional, se veran los cupos disponibles
								echo "<td class=".$colorCasilla.">".$estado["camilla"]."</td>",
								"<td class=".$colorCasilla.">".$estado["gimnasio"]."</td>";
							} else { */
							echo "<td class=".$colorCasilla.">".cantidadCupos($cantCamillas, $GLOBALS['MaximoCamillas'])."</td>",
							"<td class=".$colorCasilla.">".cantidadCupos($cantGimnasio, $GLOBALS['MaximoGimnasio'])."</td>";
							

							if ($disponibilidad == "Disponible") { 
								echo "<td class=".$colorCasilla."><input type='button' value='Si' onclick='location=\"reservar.php?fecha=".$fecha."&hora=".$hora."\";'/></td>";
							} else {
								echo "<td class=".$colorCasilla.">No</td>";
							}
							
						} elseif (verificarLaborable($hora, $dia) == false) {
							//Si la hora dada no es laboral el dia dado, entonces
							echo "<td class='cerrado'>-</td>", 
							"<td class='cerrado'>-</td>",
							"<td class='cerrado'>-</td>";
						}
					} 
				}
				if ($vacio == true) {
						if(verificarLaborable($hora, $dia)) {
							if ($GLOBALS['perfil'] == "profesional") {
								echo "<td class='libre'>".$GLOBALS['MaximoCamillas']."</td>", "<td class='libre'>".$GLOBALS['MaximoGimnasio']."</td>";
							} else {
								echo "<td class='libre'>Si</td>", "<td class='libre'>Si</td>"; 
							} 
							echo "<td class='libre'><input type='button' value='Si' onclick='location=\"reservar.php?fecha=".$fecha."&hora=".$hora."\";'/></td>";
						} else {
							//Si la hora dada no es laboral el dia dado, entonces
							echo "<td class='cerrado'>-</td>", 
							"<td class='cerrado'>-</td>",
							"<td class='cerrado'>-</td>";
						}
				}
			}
		}
		echo "</tr>";
	}
}

function consultarTurnosSemana($fechaInicio, $fechaFin) { //Funcion que devuelve array con los turnos del dia
	
	//Armar consulta
	if(isset($_POST['patologias'])) {
		$consultaTurnos = "SELECT COUNT(ID_TURNO) as cantidad, FECHA_TURNO, HORA_TURNO, PATOLOGIA.DESCRIPCION as patologia FROM TURNOS JOIN TIPO_SESION";
		$consultaTurnos.= " ON ID_TIPO_SESION = RELA_TIPO_SESION JOIN ESTADO_TURNO ON ID_ESTADO_TURNO = RELA_ESTADO_TURNO JOIN PATOLOGIA ";
		$consultaTurnos.= "ON ID_PATOLOGIA = RELA_PATOLOGIA GROUP BY HORA_TURNO, FECHA_TURNO, PATOLOGIA.DESCRIPCION, ESTADO_TURNO ";
		$consultaTurnos.= "HAVING FECHA_TURNO >= '".$fechaInicio."' AND FECHA_TURNO <= '".$fechaFin."' AND ESTADO_TURNO = 'Pendiente' AND PATOLOGIA.DESCRIPCION LIKE '".$_POST['patologias']."'"; 
	} else {
		$consultaTurnos="SELECT COUNT(ID_TURNO) as cantidad, FECHA_TURNO, HORA_TURNO FROM TURNOS JOIN TIPO_SESION ON ID_TIPO_SESION = ";
		$consultaTurnos.="RELA_TIPO_SESION JOIN ESTADO_TURNO ON ID_ESTADO_TURNO = RELA_ESTADO_TURNO JOIN PATOLOGIA ON ID_PATOLOGIA = RELA_PATOLOGIA";
		$consultaTurnos.=" GROUP BY HORA_TURNO, FECHA_TURNO, ESTADO_TURNO HAVING FECHA_TURNO >= '".$fechaInicio."' AND FECHA_TURNO <= '".$fechaFin."' AND ESTADO_TURNO = 'Pendiente'";
	}
	//Realizar Consulta
	return consulta($consultaTurnos);
}


function obtenerCantidadCupos($hora, $matriz, $tipo, $fecha) {	//Contador de cantidades de cupos para semana
	$contador = 0;
	foreach($matriz as $registro=>$campo) {
		if($campo['sesion'] == $tipo && $campo['HORA_TURNO'] == $hora && $fecha == $campo['FECHA_TURNO']) {
			$contador+= $campo['cantidad'];
		}
	}
	return $contador;
}
?>
<body>

<form>
	<input type="button" value="Ver Mes" / onclick="location='calendario.php';">
	<input type="button" value="Ver Semana" onclick="location='agenda-semana.php';" />
	<input type="button" value="Ver Dia" onclick="location='agenda-dia.php';"/>
</form>

<form action="agenda-semana.php" method="post">
	<?php
		comboEspecialidades();
		comboPatologias();
	?>
	<input type="submit" value="Filtrar" />

	<div width="100%" class="table-responsive-sm ">

		<table class="table table-bordered table-hover" style="text-align:center">
			<tr>
				<th rowspan=2 class="center scope="col"><img src="../assets/images/avatars/reloj.png"/></th>
				
				<th colspan=3 class="center scope="col">Lunes <?php echo formatFecha($matrizSemana["Lunes"], "normal"); ?></th>
				<th colspan=3 class="center scope="col">Martes <?php echo formatFecha($matrizSemana["Martes"], "normal"); ?></th>
				<th colspan=3 class="center scope="col">Miércoles <?php echo formatFecha($matrizSemana["Miercoles"], "normal"); ?></th>
				<th colspan=3 class="center scope="col">Jueves <?php echo formatFecha($matrizSemana["Jueves"], "normal"); ?></th>
				<th colspan=3 class="center scope="col">Viernes <?php echo formatFecha($matrizSemana["Viernes"], "normal"); ?></th>
				<th colspan=3 class="center scope="col">Sábado <?php echo formatFecha($matrizSemana["Sabado"], "normal"); ?></th>
			</tr>
			<tr>
				<td class="center scope="col"><img src="../assets/images/avatars/camilla.png"/></td> <td class="center scope="col"><img src="../assets/images/avatars/gim.png"/></td> <td class="center scope="col"><img src="../assets/images/avatars/reservar.png"/></td>
				<td class="center scope="col"><img src="../assets/images/avatars/camilla.png"/></td> <td class="center scope="col"><img src="../assets/images/avatars/gim.png"/></td> <td class="center scope="col"><img src="../assets/images/avatars/reservar.png"/></td>
				<td class="center scope="col"><img src="../assets/images/avatars/camilla.png"/></td> <td class="center scope="col"><img src="../assets/images/avatars/gim.png"/></td> <td class="center scope="col"><img src="../assets/images/avatars/reservar.png"/></td>
				<td class="center scope="col"><img src="../assets/images/avatars/camilla.png"/></td> <td class="center scope="col"><img src="../assets/images/avatars/gim.png"/></td> <td class="center scope="col"><img src="../assets/images/avatars/reservar.png"/></td>
				<td class="center scope="col"><img src="../assets/images/avatars/camilla.png"/></td> <td class="center scope="col"><img src="../assets/images/avatars/gim.png"/></td> <td class="center scope="col"><img src="../assets/images/avatars/reservar.png"/></td>
				<td class="center scope="col"><img src="../assets/images/avatars/camilla.png"/></td> <td class="center scope="col"><img src="../assets/images/avatars/gim.png"/></td> <td class="center scope="col"><img src="../assets/images/avatars/reservar.png"/></td>
			</tr>
			<?php
				$horarioActual = consultarTurnosSemana($matrizSemana['Lunes'], $matrizSemana['Sabado']); //Guardo la matriz de turnos de las fechas inicio y fin dadas
				armarSemana($horarios, $horarioActual, $matrizSemana);
			?>
		</table>
	
	</div>
	
</form>



</body>
</html>
