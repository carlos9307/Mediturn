<?php 
	require_once("../clases/coneccion.php");
	require_once("sys_crud.php");

	class cargardatos{

		private $objbd;
		private $abm;
		private $result;
		private $limite;

		public function __construct(){
			$this->objbd = new database;//instanciamos la base
			$this->abm = new crud($this->objbd);
		}

		public function verificardatos($tabla,$columna,$valor){//verifica en la tabla si se encuentra cierto registro

			$cant=$this->abm->getRows($tabla,array('where'=>array($columna=>$valor),//recibe el nombre de la tabla, la columna donde se encuntra el dato y el dato
														 'return_type'=>'count'));
			if($cant>0){
				 return true;
			}else{
				return false;
			}
		}

		public function extraerid($extraer,$sql,$datos){//busca en la tabla un registro y extrae uno  o los campos seleccionados

			$stmt = $this->objbd->prepare($sql);
			if ($datos != "") {
				$stmt->bindParam(':dato',$datos);
			}
			$stmt->execute();//ejecutamos la sentencia
			$this->result = $stmt->fetchAll();//extraemos los datos
			$cant = count($this->result);
			
			if($cant>0 and $extraer == "todo"){
				 return $this->result;
			}elseif($cant>0){
				return $this->result[0][$extraer];
			}else{
				return false;
			}
		}

		public function cargardatos($tabla,$datos,$devolverid){//carga los datos en la tabla

			$this->objbd->beginTransaction();
			$id= $this->abm->insert($tabla,$datos);
			$this->objbd->commit();
			if ($devolverid == 'si') {
				return $id;
			}
				
		}

		public function actualizardatos($tabla,$datos,$columna,$cond){//modifica valores de los registros

			$this->objbd->beginTransaction();
			$id= $this->abm->update($tabla,$datos,array($columna=>$cond));
			$this->objbd->commit();
		}
	}
?>