	<?php 

		require_once("../clases/cargardatos.php");

		if(isset($_POST['registrar'])){//controla que se halla enviado el formulario

			if ( $_POST['pass'] == $_POST['pass2']) {//verifica si ingreso bien las contraseñas
				
				$dni = $_POST['dni'] ? intval($_POST['dni']) : '';
				$usuario = $_POST['usuario'] ? strval($_POST['usuario']) : '';
				$pass = $_POST['pass'] ? strval($_POST['pass']) : '';

				$objcd = new cargardatos();

				$idpersona = $objcd->extraerid('ID_Persona',"SELECT * FROM personas WHERE dni = :dato",$dni);//extraemos la id de la persona

				if($idpersona > 0 ){//consultamos si existe la persona

					if ($objcd->verificardatos('usuarios','RELA_PERSONA',$idpersona) == false) { //si es que esta persona tiene o no una cuenta asociada

						if($objcd->verificardatos('usuarios','USUARIO_NOMBRE',$usuario) == false){//consultamos si existe el usuario

							echo $idpersona.'<BR>'.$usuario.'<BR>'.$pass.'<BR>';

							/*$objcd->cargardatos('usuarios',$datos=array("ID_USUARIO"=>null,
																	"RELA_PERSONA"=>$idpersona,
																	"RELA_TIPO_CUENTA"=>'02',
																	"USUARIO_NOMBRE"=>$usuario,
																	"CONTRASENA"=>$pass,
																	));//cargamos usuario*/
						}else{
							header("location: ..//paginas/registrarus.php?error=2");//si existe la cuenta nos mandara de regreso al registro
						}

					}else{

						header("location: ..//paginas/registrarus.php?error=4");//si la persona ya tiene una cuenta saldra error
					}

				}else{
					header("location: ..//paginas/registrarus.php?error=1");//si existe un mismo nombre de usuario nos mandara de regreso al registro
				}
			}else{
				header("location: ..//paginas/registrarus.php?error=3");//si las contraseñas no coinciden
			}
		}else{
			header("location: ..//paginas/registrarus.php");
		}

		

	?>
