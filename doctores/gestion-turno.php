<?php 
	include('calendario-funciones.php');
	if ($_SESSION['perfil'] == 'Administrador') {
		if (isset($_GET['idturno']) && isset($_GET['operacion'])) {
			$idTurno = $_GET['idturno'];
			$operacion = $_GET['operacion'];
			switch($operacion) {
				case 1:
					//Poner el turno como atendido
					modificarBD("UPDATE TURNOS SET RELA_ESTADO_TURNO = 2 WHERE ID_TURNO = ".$idTurno);
					mensaje('atendido', $idTurno);
					break;
				case 2:
					//Poner el turno como ausente
					modificarBD("UPDATE TURNOS SET RELA_ESTADO_TURNO = 3 WHERE ID_TURNO = ".$idTurno);
					mensaje('ausente', $idTurno);
					break;
				case 3:
					modificarBD("DELETE FROM TURNOS WHERE ID_TURNO =".$idTurno);
					mensaje('cancelado', $idTurno);
					break;
			}
			echo "<script>window.location = 'index.php';</script>";	
		}
	}	

function mensaje($tipo, $id) {
	if($tipo == "atendido") {
		echo "<script>alert('Turno Nº".$id." marcado como atendido');</script>";
	} elseif ($tipo == "ausente") {
		echo "<script>alert('Turno Nº".$id." marcado como ausente');</script>";
	} elseif ($tipo == "cancelado") {
		echo "<script>alert('Turno Nº".$id." cancelado');</script>";
	}
}
?>
