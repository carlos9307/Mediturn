<?php 
	
	require_once("coneccion.php");
	require_once("sesiones.php");

	class verusuario{
		
		private $objdb;
		private $objses;
		private $result;
		private $pass;
		private $passcrypt;

		public function __construct(){

			$this->objdb = new database();//instanciamos la clase conexion
			$this->objses = new sesion();	
		}	

		public function verificarcuenta(){//para verificar la contraseña

			$stmt = $this->objdb->prepare("SELECT USUARIO_NOMBRE, CONTRASENA FROM usuarios WHERE USUARIO_NOMBRE = :us");//preparamos la sentencia sql
			$stmt->bindParam(':us',$_POST["us"]);
			$stmt->execute();//ejecutamos la sentencia
			$this->result = $stmt->fetchAll();//extraemos los datos

			if($this->result != null){
				
				$this->pass = $_POST["pass"];
				$this->passcrypt = $this->result[0]['CONTRASENA'];

				if ($this->passcrypt == $this->pass) {
					$this->loguear();
				}else{
					header('location: ..//login/login.php?error=2');;//si la contraseña es incorrecta volvera al login
					exit;
				}
			}else{
				header('location: ..//login/login.php?error=1');//SI EL USUARIO NO ESTA REDIRIGE AL LOGIN
				exit;
			}
		}
			

		public function loguear(){

			$stmt = $this->objdb->prepare("SELECT DESCRIPCION, USUARIO_NOMBRE, personas.* FROM usuarios INNER JOIN tipo_cuenta ON usuarios.RELA_TIPO_CUENTA = tipo_cuenta.ID_TIPO_CUENTA INNER JOIN personas ON usuarios.RELA_PERSONA = personas.ID_Persona WHERE usuarios.USUARIO_NOMBRE = :us");//preparamos la sentencia sql
			
			$stmt->bindParam(':us',$_POST["us"]);
			$stmt->execute();//ejecutamos la sentencia
			$this->result = $stmt->fetchAll();//extraemos los datos
			
			if ($this->result != NULL) {//comparamos los resultados

				$this->objses->guardarses('id_persona',$this->result[0]['ID_Persona']);
				$this->objses->guardarses('nombre',$this->result[0]['Nombre']);
				$this->objses->guardarses('apellido',$this->result[0]['Apellido']);
				$this->objses->guardarses('fecha_nacimiento',$this->result[0]['Fecha_Nac']);
				$this->objses->guardarses('dni',$this->result[0]['DNI']);
				$this->objses->guardarses('usuario',$this->result[0]['USUARIO_NOMBRE']);
				$this->objses->guardarses('tipo_cuenta',$this->result[0]['DESCRIPCION']);
				if ($this->result[0]['Sexo'] == 'M') {
					$this->objses->guardarses('sexo','Hombre');
				}elseif ($this->result[0]['Sexo'] == 'F') {
					$this->objses->guardarses('sexo','Mujer');
				}
				echo $_SESSION['tipo_cuenta'];

				if ($_SESSION['tipo_cuenta'] =="Administrador") {
					header('location: ..//doctores/index.php');//nos lleva a la pagina de usuarios administradores
					exit;
				}elseif ($_SESSION['tipo_cuenta'] == "Paciente") {
					header('location: ..//pacientes/index.php');//nos lleva a pagina de usuarios comunes
					exit;
				}
				
			}
			else{
				header('location: ..//login/login.php?error=1');//si no hay datos encontrados nos lo dira
				exit;
			}

		}
	}
 ?>