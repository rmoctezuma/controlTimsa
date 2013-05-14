<?php
include_once("../includes/generic.connection.php");
require_once("Sello.php");

	Class ListaSellos{

		private $flete;
		private $contenedor;
		private $sellos = array();

		function createListaSellos($sellos,$flete,$contenedor){
			$this->sellos = $sellos;
			$this->flete = $flete;
			$this->contenedor = $contenedor;
		}

		function getSellosDeContenedor($contenedor,$flete){
			try{

				$PDOmysql = consulta();

				$sql = 'SELECT contenedorsellos.Sello,contenedorsellos.NumeroSello, contenedorsellos.fecha_sellado
						 FROM contenedorsellos
						 WHERE contenedorsellos.Contenedor = :contenedor
						 and contenedorsellos.NumFlete = :flete';

				$stmt = $PDOmysql->prepare($sql);
	            $stmt->bindParam(':contenedor', $contenedor);
	            $stmt->bindParam(':flete', $flete);
	            $stmt->execute();
	            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	            $this->flete = $flete;
	            $this->contenedor = $contenedor;

	            foreach ($rows as $fila) {
	            	$sello = new Sello;
	            	$sello->createSello($fila['Sello'], $fila['NumeroSello'], $fila['fecha_sellado']);

	            	$this->sellos[] = $sello;

	            }
			} catch(PDOException $e){

			}
		}

		public function get_flete(){
			return $this->flete;
		}
		public function set_flete($flete){
			 $this->flete = $flete;
		}
		public function get_contenedor(){
			return $this->contenedor;
		}
		public function set_contenedor($contenedor){
			 $this->contenedor = $contenedor;
		}
		public function get_sellos(){
			return $this->sellos;
		}
		public function set_sellos($sellos){
			 $this->sellos = $sellos;
		}


	}
?>