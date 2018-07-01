<?php
include('conexion.php');

$query="SELECT id_medico, rela_persona, nombre, apellido FROM personas, medicos where id_persona=id_medico ORDER BY apellido";
$result = consulta($query);
echo '<option value="0">Seleccionar</option>';
foreach($result as $registro=>$campo) {
    echo '<option value="'.$campo["id_medico"].'">'.$fila["apellido"].' '.$fila['nombre'].'</option>';
}

?>
