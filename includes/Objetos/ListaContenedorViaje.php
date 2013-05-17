<?php
include_once("../includes/generic.connection.php");
require_once("Contenedor.php");
require_once("ListaSellos.php");

	Class ListaContenedorViaje{
		private $flete;
		private $contenedores;

		function createListaContenedorViaje($flete,$contenedores){
			$this->flete = $flete;
			$this->contenedores = $contenedores;
		}

		function getContenedoresDeViaje($flete){
			try{

				$PDOmysql = consulta();

				$sql = 'SELECT Contenedor_Viaje.Contenedor
						 FROM  Contenedor_Viaje
						 WHERE Contenedor_Viaje.Flete_idFlete = :flete';

				$stmt = $PDOmysql->prepare($sql);
	            $stmt->bindParam(':flete', $flete);
	            $stmt->execute();
	            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	            $this->flete = $flete;
	            $Listacontenedores = array();
	            
	            foreach ($rows as $fila) {
	            	$contenedor = new Contenedor;

	            	$contenedor->getContenedorDeViaje($fila['Contenedor'], $flete);

	            	$Listacontenedores[] = $contenedor;
	            }

	            $this->contenedores = $Listacontenedores;


			} catch(PDOException $e){
				echo "Error";
			}
		}

		public function __toString(){
        	return $this->id;
    	}

		function insertarContenedor(){

		}

		public function get_flete(){
			return $this->flete;
		}
		public function set_flete($flete){
			 $this->flete = $flete;
		}

		public function get_contenedores(){
			return $this->contenedores;		
		}
		public function set_contenedores(){
			$this->contenedores = $contenedores;
		}

	}
?>