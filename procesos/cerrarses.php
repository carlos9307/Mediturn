<?php 
	require_once("..//clases/sesiones.php");
	$objses = new sesion();
	$objses->destruirses();
	header('location: ..//index.php');
	exit;
?>