<?php
/* incluimos primeramente el archivo que contiene la clase fpdf */
include('calendario-funciones.php');
include ('../fpdf/fpdf.php');

if($_POST['idpaciente'] != "") {

//realizo el insert
cargarTurno($_POST['fechaturno'], $_POST['horario'], $_POST['idpaciente'], $_POST['patologia'], $_POST['tiposesion']);

//traer datos del turno agregado 
$consulta="SELECT ID_TURNO FROM TURNOS WHERE RELA_PACIENTE = ".$_POST['idpaciente']." AND FECHA_TURNO = '".$_POST['fechaturno']."' AND HORA_TURNO = '".$_POST['horario']."'";
$arrayTurno = consulta($consulta);
$turno = $arrayTurno[0]['ID_TURNO'];

//sacar datos de persona
$paciente = consulta("SELECT ID_PERSONA, APELLIDO, NOMBRE, DNI FROM PERSONAS JOIN PACIENTES ON ID_PERSONA = RELA_PERSONA WHERE ID_PACIENTE = ".$_POST['idpaciente']);

//sacar datos del tipo de sesion
$tipoSesion = consulta("SELECT DESCRIPCION FROM TIPO_SESION WHERE ID_TIPO_SESION =".$_POST['tiposesion']);
$nTipoSesion = $tipoSesion[0]['DESCRIPCION'];

//sacar datos de patologia
$patologia = consulta("SELECT DESCRIPCION FROM PATOLOGIA WHERE ID_PATOLOGIA =".$_POST['patologia']);
$nPatologia = $patologia[0]['DESCRIPCION'];


$nombrePaciente = $paciente[0]['APELLIDO']." ".$paciente[0]['NOMBRE'];
$dni = $paciente[0]['DNI'];

/* tenemos que generar una instancia de la clase */
        $pdf = new FPDF();
        $pdf->AddPage();

/* seleccionamos el tipo, estilo y tamaño de la letra a utilizar */
        $pdf->SetFont('Helvetica', 'B', 14);
        $pdf->SetTextColor(44, 202, 220);
        //$pdf->Image('../img/titulo-pdf.png',85,10,40);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->write(7, " ");
        $pdf->Ln();
        $pdf->Ln();
		$pdf->Write (7,"ID Turno: ".$turno);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Write (7,"Paciente: ".$nombrePaciente);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetTextColor(18, 144, 178);
		$pdf->Write (7,"Hora: ".$_POST['horario']."                      "."Fecha: ".$_POST['fechaturno']);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Write (7,"Patologia a tratar: ".$nPatologia);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Write (7,"Tipo de Sesión: ".$nTipoSesion);
		$pdf->Line(0,160,300,160);//impresión de linea
        $pdf->Output("../fpdf/prueba.pdf",'F');
		echo "<script language='javascript'>window.open('../fpdf/prueba.pdf','_self','');</script>";//para ver el archivo pdf generado
		exit;
} else {
	echo "<script>alert('Por favor, seleccione un paciente');</script>";
	echo "<script>window.location='reservar.php'</script>";

}
?>
