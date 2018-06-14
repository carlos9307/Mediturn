<?php
include('funciones.php');
//Variables y Arrays
$GLOBALS['perfil'] = "profesional";
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
	$consultaTurnos = "SELECT COUNT(ID_TURNO) as cantidad, FECHA_TURNO, HORA_TURNO, ESTADO_TURNO FROM TURNOS ";
	$consultaTurnos.= "JOIN TIPO_SESION ON ID_TIPO_SESION = RELA_TIPO_SESION JOIN ESTADO_TURNO ON ID_ESTADO_TURNO = RELA_ESTADO_TURNO ";
	$consultaTurnos.= "JOIN PATOLOGIA ON ID_PATOLOGIA = RELA_PATOLOGIA GROUP BY HORA_TURNO, FECHA_TURNO, ESTADO_TURNO";
	 $consultaTurnos .=" HAVING FECHA_TURNO = '".$fechaActual."' AND ESTADO_TURNO = 'Pendiente'";
	
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
	if($GLOBALS['perfil'] == "profesional") {
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
	$Patologias = array("Dolor de Espalda", "Artrosis", "Lumbalgia");
	echo "<select name='patologias'>";
	foreach($Patologias as $enfermedad) {
		echo "<option>".$enfermedad."</option>";
	}
	echo "</select>";
}

function comboEspecialidades() {
//Funcion para cargar los combos de las especialidades
	$especialidades = array("Kinesiologo", "Urologo");
	echo "<select name='especialidades' id='especialidades'>";
	foreach($especialidades as $nombre) {
		echo "<option>".$nombre."</option>";
	}
	echo "</select>";
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
	$consulta ="SELECT COUNT(ID_TURNO) as cantidad, FECHA_TURNO, HORA_TURNO, ESTADO_TURNO, TIPO_SESION.DESCRIPCION as sesion, PATOLOGIA.DESCRIPCION as patologia";
	$consulta.=" FROM TURNOS JOIN TIPO_SESION ON ID_TIPO_SESION = RELA_TIPO_SESION JOIN ESTADO_TURNO ";
	$consulta.="ON ID_ESTADO_TURNO = RELA_ESTADO_TURNO JOIN PATOLOGIA ON ID_PATOLOGIA = RELA_PATOLOGIA GROUP BY ";
	$consulta.="HORA_TURNO, TIPO_SESION.DESCRIPCION, PATOLOGIA.DESCRIPCION, FECHA_TURNO, ESTADO_TURNO HAVING ";
	$consulta.="FECHA_TURNO = '".$fecha."' AND HORA_TURNO = '".$hora."' AND ESTADO_TURNO = 'Pendiente'";
	return consulta($consulta);
}
?>