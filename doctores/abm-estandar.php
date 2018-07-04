<?php
include('personas-funciones.php'); 
if($_SESSION['perfil'] == "Administrador") {
    accionesPaciente($_GET['tipo']);
}

function accionesPaciente($tipo) {
    if(isset($_GET['idpaciente'])) { 
        $idpaciente = $_GET['idpaciente'];
    } elseif(isset($_POST['idpaciente'])) {
        $idpaciente = $_POST['idpaciente'];
    }
    if (isset($idpaciente)) {
        $consulta = consulta("SELECT ID_PERSONA FROM PERSONAS JOIN PACIENTES ON ID_PERSONA = RELA_PERSONA WHERE ID_PACIENTE = ".$idpaciente);
        $personaID = $consulta[0]['ID_PERSONA'];
    }
    if ($tipo == "mod") {
        modificarBD("UPDATE PERSONAS SET APELLIDO = '".$_POST['apellido']."', NOMBRE = '".$_POST['nombre']."', FECHA_NAC = '".$_POST['fechanac']."', DNI = '".$_POST['dni']."', SEXO = '".$_POST['sexo']."'
        WHERE ID_PERSONA = ".$personaID."");
        mensajeModif("El registro de la persona ha sido modificado correctamente");
    } elseif($tipo == "nuevo") {
        modificarBD("INSERT INTO PERSONAS(APELLIDO, NOMBRE, FECHA_NAC, DNI, SEXO) VALUES('".$_POST['apellido']."', '".$_POST['nombre']."', '".date('Y-m-d', strtotime($_POST['fechanac']))."', '".$_POST['dni']."', '".$_POST['sexo']."')");
        $personaReciente = consulta("SELECT ID_PERSONA FROM PERSONAS WHERE DNI = '".$_POST['dni']."' AND APELLIDO = '".$_POST['apellido']."' AND NOMBRE = '".$_POST['nombre']."'");
        modificarBD("INSERT INTO PACIENTES(RELA_PERSONA, RELA_OBRA_SOCIAL, NUMERO_AFILIADO) VALUES(".$personaReciente[0]['ID_PERSONA'].", ".$_POST['os'].", '".$_POST['nafiliado']."')");
        if (isset($_POST['direccion'])) {
          modificarBD("INSERT INTO DIRECCIONES(RELA_LOCALIDAD, DESCRIPCION, RELA_PERSONA) VALUES('".$_POST['localidad']."', '".$_POST['direccion']."', ".$personaReciente[0]['ID_PERSONA'].")");
        }
        if (isset($_POST['telefono'])) {
          modificarBD("INSERT INTO CONTACTOS(RELA_PERSONA, RELA_TIPO_CONTACTO, VALOR) VALUES(".$personaReciente[0]['ID_PERSONA'].", 1, '".$_POST['telefono']."'");
        }
        if (isset($_POST['email'])) {
          modificarBD("INSERT INTO CONTACTOS(RELA_PERSONA, RELA_TIPO_CONTACTO, VALOR) VALUES(".$personaReciente[0]['ID_PERSONA'].", 2, '".$_POST['email']."'");
        }
        if ($_POST['creacuenta'] == "si") {
            $userypass = generarUsuario($_POST['nombre'], $_POST['apellido'], $_POST['dni']);
            modificarBD("INSERT INTO USUARIOS(RELA_PERSONA, RELA_TIPO_CUENTA, USUARIO_NOMBRE, CONTRASENA) VALUES(".$personaReciente[0]['ID_PERSONA'].", 2, '".$userypass."', '".$userypass."')");
        }
        mensajeModif("La persona ha sido registrada correctamente");
    } elseif($tipo == "borrar") {
        modificarBD("DELETE FROM PERSONAS WHERE ID_PERSONA = ".$personaID);
        modificarBD("DELETE FROM PACIENTES WHERE ID_PACIENTE = ".$idpaciente);
        mensajeModif("El registro de la persona ha sido registrado correctamente");
    }
    header('location: ../doctores/pacientes.php');
}

function mensajeModif($mensaje) {
    echo "<script>alert('".$mensaje."')</script>";
}

function generarUsuario($nombre, $apellido, $dni) {
    return $dni.substr($apellido, 1, 1).substr($nombre, 1, 1);
}

?>