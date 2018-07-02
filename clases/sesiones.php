<?php
	class sesion{

		public function __construct(){
			@session_start();
		}

		public function guardarses($nombresesion,$varses){
			$_SESSION[$nombresesion] = $varses;
		}
		
		PUBLIC function destruirses(){
			session_unset();
			session_destroy();
		}
		
	}

 ?>