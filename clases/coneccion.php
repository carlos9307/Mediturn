<?php 
	class database extends PDO{

		public function __construct(){
			//header("Content-type: text/html; charset=utf-8");
			try {
				parent::__construct('mysql:host=localhost;dbname=sango','root','');
				parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				//echo 'conexion exitosa';
			} catch (Exception $ex) {
				echo $ex.'<br>';
				die('error al conectar a la base de datos.');
			}
		}
	}
?>
