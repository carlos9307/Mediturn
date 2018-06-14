<?php 
include ("funciones.php");

function cargarTablaPacientes($claveBusqueda, $tipo){
	if (isset($_GET['buscar'])) {
		if($tipo == "dni") {
			$consulta = "SELECT ID_PERSONA, ID_PACIENTE, APELLIDO, NOMBRE, FECHA_NAC, DNI FROM PERSONAS JOIN PACIENTES ON ID_PERSONA = RELA_PERSONA WHERE DNI LIKE '".$claveBusqueda."%';";
		} elseif($tipo == "apyn") {
			$consulta = "SELECT ID_PERSONA, ID_PACIENTE, APELLIDO, NOMBRE, FECHA_NAC, DNI FROM PERSONAS JOIN PACIENTES ON ID_PERSONA = RELA_PERSONA WHERE APELLIDO LIKE '".$claveBusqueda."%' OR NOMBRE LIKE '".$claveBusqueda."%';";
		}
		echo "entro aca";
	} else {
		$consulta = "SELECT ID_PERSONA, ID_PACIENTE, APELLIDO, NOMBRE, FECHA_NAC, DNI FROM PERSONAS JOIN PACIENTES ON ID_PERSONA = RELA_PERSONA";		
	}

	$matrizPersonas = consulta($consulta);

	foreach ($matrizPersonas as $tabla=>$registro) {
		echo "<tr><td>".$registro['ID_PERSONA']."</td>",
		"<td>".$registro['APELLIDO']."</td>",
		"<td>".$registro['NOMBRE']."</td>",
		"<td>".$registro['DNI']."</td>",
		"<td>".$registro['FECHA_NAC']."</td>";
		echo "<td>";
		botonesRegistro($registro['ID_PERSONA'], "PERSONAS");
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

?>