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

		function insertar_sellos(){

			$listaSellos = $this->sellos;

			for($nuevoContador = 0; $nuevoContador < count($listaSellos); $nuevoContador++){
				//insercion de sello.
				$sello = $listaSellos[$nuevoContador];

				$sql = 'insert into ContenedorSellos(Sello,NumeroSello, NumFlete, Contenedor) values(:sello, :numeroSello, :numeroFlete, :contenedor);';

				$stmt = $PDOmysql->prepare($sql);

				$stmt->bindParam(':sello', $sello->get_sello());
				$stmt->bindParam(':numeroSello', $sello->get_numero_sello());
				$stmt->bindParam(':numeroFlete', $this->flete);
				$stmt->bindParam(':contenedor', $this->contenedor);
				$stmt->execute();
			}
		}

		public function append_sello($sello){
			array_push($this->sellos,$sello);	
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