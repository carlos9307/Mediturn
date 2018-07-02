<?php
include('funciones.php');
//Variables y Arrays
$_SESSION['perfil'] = "Administrador";
$GLOBALS['MaximoCamillas'] = 4;
$GLOBALS['MaximoGimnasio'] = 6;

//array con los horarios, de simulacro
/*$horarioActual = array("20:00"=>array("camilla"=>"4", "gimnasio"=>"0", "patologia"=>"Dolor de Espalda", "dia"=>"18-05-2018"), 
				  "21:00"=>array("camilla"=>"4", "gimnasio"=>"6", "patologia"=>"Lumbalgia", "dia"=>"17-05-2018"),
				  "22:00"=>array("camilla"=>"4", "gimnasio"=>"6", "patologia"=>"Dolor de Espalda", "dia"=>"14-05-2018"), 
				  "18:00"=>array("camilla"=>"2", "gimnasio"=>"2", "patologia"=>"Lumbalgia", "dia"=>"15-05-2018"),
				  "19:20"=>array("camilla"=>"4", "gimnasio"=>"6", "patologia"=>"Lumbalgia", "dia"=>"16-05-2018"));*/

/*foreach ($horarioActual as $matriz=>$turnos) {
		echo $turnos['cantidad'];
	echo "<br/>";
}*/

//$horarios = array("10:00", "10:40", "11:20", "12:00", "12:40", "13:20", "14:00", "14:40", "15:20", "16:00", "16:40", "17:20", "18:00", "18:40", "19:20", "20:00", "20:40", "21:00", "21:40", "22:00");
$dias = array(0=>"Domingo", 1=>"Lunes", 2=>"Martes", 3=>"Miercoles", 4=>"Jueves", 5=>"Viernes", 6=>"Sabado");

function armarHorarioDia($fecha) { //Funcion que a partir de una fecha devuelve array con horarios del dia
	if(sacarDia($fecha) != "Domingo") {
		$consulta = "SELECT ID_JORNADA, HORA_DESDE, HORA_HASTA FROM JORNADAS WHERE DIA LIKE '".sacarDia($fecha)."'";
		$jornada = consulta($consulta);
		foreach($jornada as $query=>$registro) {
			$horaActual = date("H:i", strtotime($registro['HORA_DESDE']));	//Guardo la hora inicial en el acumulador
			$jornadaFinal[] = $horaActual;	//Guardo la hora inicial en la matriz
			while(strtotime($horaActual) < strtotime($registro['HORA_HASTA'])) {	//Mientras que la hora actual sea menor a la hora hasta
				$horaActual = date('H:i', strtotime($horaActual.' 0 hours + 30 minutes'));	//Sumo el acumulador media hora
				$jornadaFinal[] = $horaActual;	//Añado la hora que acabo de sumar a la matriz
			}
		}
		return $jornadaFinal;
	} else {
		$jornadaFinal[] = "Sin horarios";	//Si es domingo, no cargar horarios
		return $jornadaFinal;
	}
}

function consultarTurnosDia($fechaActual) { //Funcion que devuelve array con los turnos del dia
	
	//Armar consulta
	if (isset($_POST['patologias'])) {
		$consultaTurnos ="SELECT COUNT(ID_TURNO) as cantidad, PATOLOGIA.DESCRIPCION as patologia, FECHA_TURNO, ";
		$consultaTurnos.= "HORA_TURNO, ESTADO_TURNO FROM TURNOS JOIN TIPO_SESION ON ID_TIPO_SESION = RELA_TIPO_SESION";
		$consultaTurnos.=" JOIN ESTADO_TURNO ON ID_ESTADO_TURNO = RELA_ESTADO_TURNO JOIN PATOLOGIA ON ID_PATOLOGIA = ";
		$consultaTurnos.="RELA_PATOLOGIA GROUP BY HORA_TURNO, FECHA_TURNO, PATOLOGIA.DESCRIPCION, ESTADO_TURNO HAVING ";
		$consultaTurnos.="FECHA_TURNO = '".$fechaActual."' AND ESTADO_TURNO = 'Pendiente' AND PATOLOGIA.DESCRIPCION = '".$_POST['patologias']."'"; 
	} else {
		$consultaTurnos = "SELECT COUNT(ID_TURNO) as cantidad, FECHA_TURNO, HORA_TURNO, ESTADO_TURNO FROM TURNOS ";
		$consultaTurnos.= "JOIN TIPO_SESION ON ID_TIPO_SESION = RELA_TIPO_SESION JOIN ESTADO_TURNO ON ID_ESTADO_TURNO = RELA_ESTADO_TURNO ";
		$consultaTurnos.= "JOIN PATOLOGIA ON ID_PATOLOGIA = RELA_PATOLOGIA GROUP BY HORA_TURNO, FECHA_TURNO, ESTADO_TURNO";
		 $consultaTurnos .=" HAVING FECHA_TURNO = '".$fechaActual."' AND ESTADO_TURNO = 'Pendiente'";
	}
	//Realizar Consulta
	return consulta($consultaTurnos);
}

function estadoTurno($eCamillas, $eGimnasio) {
//Funcion para determinar si un horario esta libre u ocupado
	if ($eCamillas >= $GLOBALS['MaximoCamillas'] && $eGimnasio >= $GLOBALS['MaximoGimnasio']) {
		return "Ocupado";
	} elseif($eCamillas == 0 && $eGimnasio == 0) {
		return "Libre";
	} elseif ($eCamillas < $GLOBALS['MaximoCamillas'] OR $eGimnasio < $GLOBALS['MaximoGimnasio']) {
		return "Disponible";
	}
}

function cantidadCupos($numero, $maximo) {
//Funcion que devuelve si o no si la cantidad de cupos es mayor a x numero
	if($_SESSION['perfil'] == "profesional") {
		return $maximo - $numero;
	} else {
		if ($numero < $maximo) {
			return "Si";
		} else {
			return "No";
		}
	}
}


function comboPatologias() {
//Funcion para cargar los combos de las patologias
	$Patologias = consulta("SELECT DESCRIPCION FROM PATOLOGIA");
	echo "<select name='patologias'>";
	foreach($Patologias as $registro=>$campo) {
		echo "<option value='".$campo['DESCRIPCION']."'";
		if(isset($_POST['patologias']) && $campo['DESCRIPCION'] == $_POST['patologias']) {
			echo " selected";
		}
		echo ">".$campo['DESCRIPCION']."</option>";
	}
	echo "</select>";

}

function comboEspecialidades() {
//Funcion para cargar los combos de las especialidades
	$especialidades = consulta("SELECT DESCRIPCION FROM ESPECIALIDADES");
	echo "<select name='especialidades' id='especialidades'>";
	foreach($especialidades as $registro=>$campo) {
		echo "<option>".$campo['DESCRIPCION']."</option>";
	}
	echo "</select>";
}

function cupoPatologia($patologia, $fecha) {
	//Funcion que determina si en una fecha dada, una patologia dada esta disponible
	$semana = determinarSemana($fecha);
	$consultaP = "SELECT COUNT(ID_TURNO) as cuposdisponibles, PATOLOGIA.DESCRIPCION, CUPOS, FECHA_TURNO FROM TURNOS JOIN PATOLOGIA ON ID_PATOLOGIA = RELA_PATOLOGIA";
	$consultaP .= " GROUP BY PATOLOGIA.DESCRIPCION, CUPOS HAVING PATOLOGIA.DESCRIPCION LIKE '".$patologia."' "; 
	$consultaP .= "AND FECHA_TURNO >= '".$semana['Lunes']."' AND FECHA_TURNO <= '".$semana['Sabado']."'";
	$resultadoP = consulta($consultaP);
	if(count($resultadoP) > 0) {
		if($resultadoP[0]['CUPOS'] > $resultadoP[0]['cuposdisponibles']) {
			return true;
		} else {
			return false;
		}
	} else {
		return true;
	}
}

function sacarDia($fecha) {
	//Funcion que devuelve el nombre del dia de una fecha
	$diasSemana = array(0=>"Domingo", 1=>"Lunes", 2=>"Martes", 3=>"Miercoles", 4=>"Jueves", 5=>"Viernes", 6=>"Sabado");	
	return $diasSemana[date("w", strtotime($fecha))];
}

function corregirAcento($fechaN) {
	//Funcion que agrega acento a los dias que lo tengan de acuerdo a una fecha
	if ($fechaN == "Miercoles") {
		return "Miércoles";
	} elseif ($fechaN == "Sabado") {
		return "Sábado";
	} else {
		return $fechaN;
	}
}

function sumarFecha($fecha, $dias, $operador){
	//Funcion que dando una fecha, una cantidad de dias y un operador (+ o -) suma o resta esa cantidad de dias a la fecha dada
	return date('Y-m-d', strtotime($fecha.' '.$operador.' '.$dias.' days'));
}

function verificarLaborable($hora, $dia) {
	//Funcion que verifica si una hora en un dia es laboral o no
	$consulta = "SELECT COUNT(*) as cantidad FROM JORNADAS WHERE DIA LIKE '".$dia."' and HORA_DESDE <= '".$hora."' and HORA_HASTA >= '".$hora."'";
	$resultado = consulta($consulta);
	if ($resultado[0]["cantidad"] > 0) {
		return true;
	} else {
		return false;
	}
}

function obtenerCuposTurno($fecha, $hora) {
	//Funcion que a partir de la fecha y la hora determina los cupos para camillas y para gimnasio
	if(isset($_POST['patologias'])) {
		$consulta="SELECT COUNT(ID_TURNO) as cantidad, FECHA_TURNO, HORA_TURNO, ESTADO_TURNO, TIPO_SESION.DESCRIPCION ";
		$consulta.="as sesion, PATOLOGIA.DESCRIPCION as patologia FROM TURNOS JOIN TIPO_SESION ON ID_TIPO_SESION = ";
		$consulta.="RELA_TIPO_SESION JOIN ESTADO_TURNO ON ID_ESTADO_TURNO = RELA_ESTADO_TURNO JOIN PATOLOGIA ON";
		$consulta.=" ID_PATOLOGIA = RELA_PATOLOGIA GROUP BY HORA_TURNO, TIPO_SESION.DESCRIPCION, PATOLOGIA.DESCRIPCION, FECHA_TURNO, ESTADO_TURNO";
		$consulta.=" HAVING FECHA_TURNO = '".$fecha."' AND HORA_TURNO = '".$hora."' AND ESTADO_TURNO = 'Pendiente' AND PATOLOGIA.DESCRIPCION = '".$_POST['patologias']."'";
	} else {
		$consulta ="SELECT COUNT(ID_TURNO) as cantidad, FECHA_TURNO, HORA_TURNO, ESTADO_TURNO, TIPO_SESION.DESCRIPCION as sesion";
		$consulta.=" FROM TURNOS JOIN TIPO_SESION ON ID_TIPO_SESION = RELA_TIPO_SESION JOIN ESTADO_TURNO ";
		$consulta.="ON ID_ESTADO_TURNO = RELA_ESTADO_TURNO GROUP BY ";
		$consulta.="HORA_TURNO, TIPO_SESION.DESCRIPCION, FECHA_TURNO, ESTADO_TURNO HAVING ";
		$consulta.="FECHA_TURNO = '".$fecha."' AND HORA_TURNO = '".$hora."' AND ESTADO_TURNO = 'Pendiente'";
	}
	return consulta($consulta);
}

function formatFecha($fecha, $tipo) {
	if($tipo == "normal") {
		return date("d/m/Y", strtotime($fecha));
	} elseif($tipo == "sql") {
		return date("Y-m-d", strtotime($fecha));
	}
}

function determinarSemana($fechaActual) {
	//Funcion para devolver el array de semanas
	$fechaActual = date("Y-m-d", strtotime($fechaActual));
	if(sacarDia($fechaActual) == "Domingo") {	//Si el dia es domingo, pasamos a la semana siguiente
		$fechaActual = sumarFecha(date("Y-m-d"), 1, "+");
	}

	switch(sacarDia($fechaActual)) {	//Armamos la matriz de semana con las fechas segun que dia sea
		case "Lunes":
			$arraySemana["Lunes"] = $fechaActual;
			$arraySemana["Martes"] = sumarFecha($fechaActual, 1,"+");
			$arraySemana["Miercoles"] = sumarFecha($fechaActual, 2,"+");
			$arraySemana["Jueves"] = sumarFecha($fechaActual, 3,"+");
			$arraySemana["Viernes"] = sumarFecha($fechaActual, 4,"+");
			$arraySemana["Sabado"] = sumarFecha($fechaActual, 5,"+");
			break;
		case "Martes":
			$arraySemana["Lunes"] = sumarFecha($fechaActual, 1,"-");
			$arraySemana["Martes"] = $fechaActual;
			$arraySemana["Miercoles"] = sumarFecha($fechaActual, 1,"+");
			$arraySemana["Jueves"] = sumarFecha($fechaActual, 2,"+");
			$arraySemana["Viernes"] = sumarFecha($fechaActual, 3,"+");
			$arraySemana["Sabado"] = sumarFecha($fechaActual, 4,"+");
			break;
		case "Miercoles":
			$arraySemana["Lunes"] = sumarFecha($fechaActual, 2,"-");
			$arraySemana["Martes"] = sumarFecha($fechaActual, 1,"-");
			$arraySemana["Miercoles"] = $fechaActual;
			$arraySemana["Jueves"] = sumarFecha($fechaActual, 1,"+");
			$arraySemana["Viernes"] = sumarFecha($fechaActual, 2,"+");
			$arraySemana["Sabado"] = sumarFecha($fechaActual, 3,"+");
			break;
		case "Jueves":
			$arraySemana["Lunes"] = sumarFecha($fechaActual, 3,"-");
			$arraySemana["Martes"] = sumarFecha($fechaActual, 2,"-");
			$arraySemana["Miercoles"] = sumarFecha($fechaActual, 1,"-");
			$arraySemana["Jueves"] = $fechaActual;
			$arraySemana["Viernes"] = sumarFecha($fechaActual, 1,"+");
			$arraySemana["Sabado"] = sumarFecha($fechaActual, 2,"+");
			break;
		case "Viernes":
			$arraySemana["Lunes"] = sumarFecha($fechaActual, 4,"-");
			$arraySemana["Martes"] = sumarFecha($fechaActual, 3,"-");
			$arraySemana["Miercoles"] = sumarFecha($fechaActual, 2,"-");
			$arraySemana["Jueves"] = sumarFecha($fechaActual, 1,"-");
			$arraySemana["Viernes"] = $fechaActual;
			$arraySemana["Sabado"] = sumarFecha($fechaActual, 1,"+");
			break;
		case "Sabado":
			$arraySemana["Lunes"] = sumarFecha($fechaActual, 5,"-");
			$arraySemana["Martes"] = sumarFecha($fechaActual, 4,"-");
			$arraySemana["Miercoles"] = sumarFecha($fechaActual, 3,"-");
			$arraySemana["Jueves"] = sumarFecha($fechaActual, 2,"-");
			$arraySemana["Viernes"] = sumarFecha($fechaActual, 1,"-");
			$arraySemana["Sabado"] = $fechaActual;
			break;
	}
	return $arraySemana;
}

function cargarTurno($fecha, $hora, $paciente, $patologia, $tipoSesion) {
	$consulta="INSERT INTO TURNOS(RELA_PACIENTE, RELA_MEDICO, RELA_TIPO_SESION, FECHA_TURNO, HORA_TURNO, RELA_ESTADO_TURNO, RELA_PATOLOGIA)";
	$consulta.=" VALUES(".$paciente.", 1, ".$tipoSesion.", '".$fecha."', '".$hora."', 1, ".$patologia.")";
	modificarBD($consulta);
	echo "<script>alert('El turno para la fecha ".$fecha." y hora ".$hora." ha sido cargado correctamente');</script>";
}

function comboTipoSesion($hora, $fecha) {
//Funcion que arma el combo con las secciones disponibles para un turno dadas su hora y fecha
	$mSesiones = obtenerCuposTurno($fecha, $hora);
	$cantCamillas = 0;
	$cantGimnasio = 0;
	foreach($mSesiones as $reg=>$camp) {	//en este for asigno las cantidades para cada categoria
		if($camp['sesion'] == "Camilla") {
			$cantCamillas += $camp['cantidad'];
		} elseif($camp['sesion'] =="Gimnasio") {
			$cantGimnasio += $camp['cantidad'];
		}
	}
	$sesionTipo = consulta("SELECT ID_TIPO_SESION, DESCRIPCION, CUPOS FROM TIPO_SESION");
	echo "<select name='tiposesion'>";
	foreach($sesionTipo as $registro=>$campo) {
		if($campo['DESCRIPCION'] == "Camilla") {
			if ($cantCamillas < $campo['CUPOS']) {
				echo "<option value='".$campo['ID_TIPO_SESION']."'>".$campo['DESCRIPCION']."</option>";
			}
		} elseif($campo['DESCRIPCION'] == "Gimnasio") {
			if ($cantGimnasio < $campo['CUPOS']) {
				echo "<option value='".$campo['ID_TIPO_SESION']."'>".$campo['DESCRIPCION']."</option>";
			}
		}
	}
	echo "</select>";
}

function verificarFeriado($fecha) {
	//Funcion que verifica si un dia es feriado (en desuso)
	$fechaV = date('Y-m-d', strtotime($fecha));

	$consulta = "SELECT COUNT(ID_FERIADO) AS CANTIDAD FROM FERIADOS WHERE FECHA_FERIADO = '".$fechaV."'";
	$feriadoSi = consulta($consulta);	

	if($feriadoSi != NULL) {
		if($feriadoSi[0]['CANTIDAD'] > 0) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}
?>