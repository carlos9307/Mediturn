	<?php 

		require_once("../clases/cargardatos.php");

		if(isset($_POST['registropac'])){//controla que se halla enviado el formulario

			if (ctype_alpha($_POST['apellido'])) {//verifica que contenga solo letras en el apellido
				if (ctype_alpha($_POST['nombre'])) {//verifica que contenga solo letras en el nombre

					$objcd = new cargardatos;

					$telefono = "";
					$email = "";
					$obrasocial = "";
					$nafiliado = "";
					$direccion = "";

					if (ctype_digit($_POST['dni']) and $objcd->verificardatos('personas','DNI',$_POST['dni']) == false){

						if ($_POST['sexo'] == null) {
							header('location: ..//doctores/pacientes-agregar.php?error=12');
							exit;
						}
						if ($_POST['telefono'] != null and ctype_digit($_POST['telefono'])) {

							$telefono = $_POST['telefono'];
							
							/*if ($objcd->verificardatos('contactos','VALOR',$_POST['telefono']) == false) {//verifica que telefono ingresado no estee cargado
								
							}else{
								header('location: ..//doctores/pacientes-agregar.php?error=5');//el telefono ingresado ya pertenece a otra persona
								exit;
							}*/

						}elseif ($_POST['telefono'] != null) {
							header('location: ..//doctores/pacientes-agregar.php?error=6');//telefono ingresado tiene letras
							exit;

						}



						if ($_POST['email'] != null and filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {

							if ($objcd->verificardatos('contactos','VALOR',$_POST['email']) == false) {//verifica que email ingresado no estee cargado
								$email = $_POST['email'];
							}else{
								header('location: ..//doctores/pacientes-agregar.php?error=7');//el email ingresado esta asociado a una persona
								exit;
							}

						}elseif ($_POST['email'] != null) {
							header('location: ..//doctores/pacientes-agregar.php?error=8');//email fue mal introducido
							exit;
						}

						if ($_POST['os'] != 'Sin Obra Social' and $_POST['nafiliado']!= null and ctype_digit($_POST['nafiliado'])) {

							$obrasocial = $objcd->extraerid('ID_OBRA_SOCIAL',"SELECT ID_OBRA_SOCIAL FROM obras_sociales WHERE DESCRIPCION_OS = :dato",$_POST['os']);

							if (($objcd->extraerid('ID_PACIENTE',"SELECT * FROM pacientes WHERE RELA_OBRA_SOCIAL = '$obrasocial' AND NUMERO_AFILIADO = :dato",$_POST['nafiliado'])) == null) {

								$nafiliado = $_POST['nafiliado'];

							}else{
								header('location: ..//doctores/pacientes-agregar.php?error=9');//el numero de afiliado ingresado esta asociado a una persona
								exit;
							}

						}elseif ($_POST['os'] != 'Sin Obra Social' and $_POST['nafiliado']!= null) {//si ingreso obra social pero ingreso mal el numero de afiliado
							header('location: ..//doctores/pacientes-agregar.php?error=10');
							exit;
						}elseif ($_POST['os'] != 'Sin Obra Social'and $_POST['nafiliado']== null) { //selecciono obra social pero no ingreso numero de afiliado
							header('location: ..//doctores/pacientes-agregar.php?error=11');
							exit;
						}

						if ($_POST['direccion'] != null) {//verificamos si agrego una direccion
							$direccion = $_POST['direccion'];		
						}


						$nombre = $_POST['nombre'];
						$apellido = $_POST['apellido'];
						$dni = $_POST['dni'];
						$sexo = $_POST['sexo'];
						$fnacimiento = $_POST['fechanac'];
						$codpostal = $_POST['codpostal'];

						$idpersona = $objcd->cargardatos('personas',$datos=array("ID_Persona"=>null,
																	"Apellido"=>$apellido,
																	"Nombre"=>$nombre,
																	"Fecha_Nac"=>$fnacimiento,
																	"DNI"=>$dni,
																	"SEXO"=>$sexo,
																	),'si');//cargamos persona

						$idlocalidad = $objcd->extraerid('ID_LOCALIDAD',"SELECT ID_LOCALIDAD FROM localidades WHERE CODIGO_POSTAL = :dato",$codpostal);//entraemos id de la localidad

						$iddireccion = $objcd->cargardatos('direcciones',$datos=array("ID_DIRECCION"=>null,
																	"RELA_LOCALIDAD"=>$idlocalidad,
																	"DESCRIPCION"=>$direccion,
																	),'si');//cargamos en la tabla direcciones

						$objcd->cargardatos('direccionxpersona',$datos=array("ID_DIRECCIONXPERSONA"=>null,
																	"RELA_PERSONA"=>$idpersona,
																	"RELA_DIRECCION"=>$iddireccion,
																	),'');//cargamos en la tabla direccionxpersona

						$objcd->cargardatos('pacientes',$datos=array("ID_paciente"=>null,
																	"RELA_PERSONA"=>$idpersona,
																	"RELA_OBRA_SOCIAL"=>$obrasocial,
																	"NUMERO_AFILIADO"=>$nafiliado,
																	),'');//cargamos en la tabla pacientes
						if ($_POST['telefono'] != null) {

							$idtipocontacto = $objcd->extraerid('ID_TIPO_CONTACTO',"SELECT ID_TIPO_CONTACTO FROM tipo_contacto WHERE DESCRIPCION_TIPO = :dato",'telefono');//entraemos id del tipo de contacto correspondiente a telefono
							$objcd->cargardatos('contactos',$datos=array("ID_CONTACTO"=>null,
																	"RELA_PERSONA"=>$idpersona,
																	"RELA_TIPO_CONTACTO"=>$idtipocontacto,
																	"VALOR"=>$telefono,
																	),'');//cargamos en la tabla pacientes
						}

						if ($_POST['email'] != null) {

							$idtipocontacto = $objcd->extraerid('ID_TIPO_CONTACTO',"SELECT ID_TIPO_CONTACTO FROM tipo_contacto WHERE DESCRIPCION_TIPO = :dato",'email');//entraemos id del tipo de contacto correspondiente a telefono
							$objcd->cargardatos('contactos',$datos=array("ID_CONTACTO"=>null,
																	"RELA_PERSONA"=>$idpersona,
																	"RELA_TIPO_CONTACTO"=>$idtipocontacto,
																	"VALOR"=>$email,
																	),'');//cargamos en la tabla pacientes*/
						}


						if($_POST['creacuenta'] != null){//comprueba si se creara o no una cuenta
							
							$pass = (strlen($nombre)) * intdiv($dni,strlen($apellido)).substr($apellido, -2);

							$objcd->cargardatos('usuarios',$datos=array("ID_USUARIO"=>null,
																	"RELA_PERSONA"=>$idpersona,
																	"RELA_TIPO_CUENTA"=>'02',
																	"USUARIO_NOMBRE"=>$dni,
																	"CONTRASENA"=>$pass,
																	),'');//cargamos usuario

							echo "SU CUENTA HA SIDO CREADA CON EXITTO".'<br>'."USUARIO:".$dni.'<br>'."CONTRASEÑA:".$pass;

						}


					}elseif (ctype_digit($_POST['dni']) and $objcd->verificardatos('personas','DNI',$_POST['dni']) == true){
						header('location: ..//doctores/pacientes-agregar.php?error=3');//dni ya pertenece a aguien
						exit;
					}else{
						header('location: ..//doctores/pacientes-agregar.php?error=4');//dni tiene caracteres incorrectos
						exit;
					}
				}else{
					header('location: ..//doctores/pacientes-agregar.php?error=2');//nombre con numeros
					exit;
				}
			}else{
				header('location: ..//doctores/pacientes-agregar.php?error=1');//apellido tiene numeros
				exit;
			}

		}else{
			header("location: ..//doctores/pacientes-agregar.php");//si no fue enviado el formulario
			exit;
		}

	?>
