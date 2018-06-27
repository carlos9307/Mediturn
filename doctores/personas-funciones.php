<?php 
include ("calendario-funciones.php");


function cargarTablaPacientes($claveBusqueda, $tipo){
	if (isset($_GET['buscar'])) {
		if($tipo == "dni") {
			$consulta = "SELECT ID_PERSONA, ID_PACIENTE, APELLIDO, NOMBRE, FECHA_NAC, DNI FROM PERSONAS JOIN PACIENTES ON ID_PERSONA = RELA_PERSONA WHERE DNI LIKE '".$claveBusqueda."%';";
		} elseif($tipo == "apyn") {
			$consulta = "SELECT ID_PERSONA, ID_PACIENTE, APELLIDO, NOMBRE, FECHA_NAC, DNI FROM PERSONAS JOIN PACIENTES ON ID_PERSONA = RELA_PERSONA WHERE APELLIDO LIKE '".$claveBusqueda."%' OR NOMBRE LIKE '".$claveBusqueda."%';";
		}
	} else {
		$consulta = "SELECT ID_PERSONA, ID_PACIENTE, APELLIDO, NOMBRE, FECHA_NAC, DNI FROM PERSONAS JOIN PACIENTES ON ID_PERSONA = RELA_PERSONA";		
	}

	$matrizPersonas = consulta($consulta);

	foreach ($matrizPersonas as $tabla=>$registro) {
		echo "<tr><td>".$registro['ID_PACIENTE']."</td>",
		"<td>".$registro['APELLIDO']."</td>",
		"<td>".$registro['NOMBRE']."</td>",
		"<td>".$registro['DNI']."</td>",
		"<td>".$registro['FECHA_NAC']."</td>";
		echo "<td>";
		if(!(isset($_SESSION['fechaTurno']))) {
			botonesRegistro($registro['ID_PACIENTE'], "PERSONAS");
		} else {
			$apynom = $registro['APELLIDO']." ".$registro['NOMBRE'];
			echo "<input type='button' value='Seleccionar' onclick='cargarPersona(".$registro['ID_PERSONA'].", \"".$apynom."\");'/>";
		}
		echo "</td></tr>";
	} 
}

function botonesRegistro($idRegistro, $tabla) { //Funcion para mostrar los botones de eliminar y editar de un registro
	echo "<div class='hidden-sm hidden-xs action-buttons'>",
				"<a class='orange' href='pacientes-agregar.php?id=".$idRegistro."&tabla=".$tabla."'>",
				"<i class='ace-icon glyphicon glyphicon-pencil bigger-130'></i></a>";
	echo "<a class='red' href='eliminar.php?id=".$idRegistro."&tabla=".$tabla."' onClick=\"return confirm('¿Borrar el registro del paciente?')\">",
		"<i class='ace-icon glyphicon glyphicon-trash bigger-130'></i></a>",
		"</div>";
											      	
}

function comboPatologiasDisponibles($fecha) {
	$listaPatologias = consulta("SELECT ID_PATOLOGIA, DESCRIPCION FROM PATOLOGIA");
	echo "<select name='patologia'>";
	foreach($listaPatologias as $registro=>$campo) {
		if(cupoPatologia($campo['DESCRIPCION'], $fecha)) {
			echo "<option value='".$campo['ID_PATOLOGIA']."'>".$campo['DESCRIPCION']."</option>";
		}
	}
	echo "</select>";
}

function agregarPaciente() {
	echo "hola";
}

?>