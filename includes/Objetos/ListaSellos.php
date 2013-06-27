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
			$contenedor =  $contenedor;
			$flete = (int) $flete;

				$PDOmysql = consulta();
				$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = 'SELECT ContenedorSellos.Sello,ContenedorSellos.NumeroSello, ContenedorSellos.fecha_sellado
						 FROM ContenedorSellos
						 WHERE ContenedorSellos.Contenedor = :contenedor
						 and ContenedorSellos.NumFlete = :flete
						 and ContenedorSellos.statusA  = "Activo"';

				$stmt = $PDOmysql->prepare($sql);
	            $stmt->bindParam(':contenedor', $contenedor);
	            $stmt->bindParam(':flete', $flete);
	            $stmt->execute();
	            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	            $this->flete = $flete;
	            $this->contenedor = $contenedor;

	            foreach ($rows as $fila) {
	            	$sello = new Sello;
	            	//Esta funcion esta mal, no se obtienen los sellos. Mal numeor de argumentos.
	            	$sello->createSello($fila['Sello'], $fila['NumeroSello'], $fila['fecha_sellado']);

	            	$this->sellos[] = $sello;

	            }
			} catch(Exception $e){
				echo $e;
			}
		}

		function insertar_sellos(){
			
			$PDOmysql = consulta();
			$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$listaSellos = $this->sellos;

			for($nuevoContador = 0; $nuevoContador < count($listaSellos); $nuevoContador++){
				//insercion de sello.
				$sello = $listaSellos[$nuevoContador];

				$sql = 'INSERT into ContenedorSellos(Sello,NumeroSello, NumFlete, Contenedor) values(:sello, :numeroSello, :numeroFlete, :contenedor)';

				$stmt = $PDOmysql->prepare($sql);

				$stmt->bindParam(':sello', $sello->get_sello());
				$stmt->bindParam(':numeroSello', $sello->get_numero_sello());
				$stmt->bindParam(':numeroFlete', $this->flete);
				$stmt->bindParam(':contenedor', $this->contenedor);
				$stmt->execute();
			}
		}

		function insertarNevoSello($sello){
			
			$PDOmysql = consulta();
			$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = 'INSERT into ContenedorSellos(Sello,NumeroSello, NumFlete, Contenedor) values(:sello, :numeroSello, :numeroFlete, :contenedor)';

				$stmt = $PDOmysql->prepare($sql);

				$stmt->bindParam(':sello', $sello->get_sello());
				$stmt->bindParam(':numeroSello', $sello->get_numero_sello());
				$stmt->bindParam(':numeroFlete', $this->flete);
				$stmt->bindParam(':contenedor', $this->contenedor);
				$stmt->execute();
			
		}

		public function actualizarSello($sello){
			$update = new Update();
			$camposUpdate =  array( "Sello" => $sello->get_sello() );

			$camposWhereUpdate = array( "NumFlete"    => $this->flete,
										"NumeroSello" => $sello->get_numero_sello(),
										"Contenedor"  => $this->contenedor);

			$update->prepareUpdate("ContenedorSellos", $camposUpdate, $camposWhereUpdate);
			$update->createUpdate();
		}

		public function eliminarUltimoSello(){
			$numero = ( $this->getLastNumberOfSello() ) - 1;

			$update = new Update();
			$camposUpdate =  array( "statusA" => 'Eliminado' );

			$camposWhereUpdate = array( "NumFlete"    => $this->flete,
										"NumeroSello" => $numero,
										"Contenedor"  => $this->contenedor);

			$update->prepareUpdate("ContenedorSellos", $camposUpdate, $camposWhereUpdate);
			$update->createUpdate();
		}

		public function append($sello){
			array_push($this->sellos,$sello);	
		}

		public function getLastNumberOfSello(){
			$numero = 0;

			foreach ($this->sellos as $sello ) {
				$temporal = (int) $sello->get_numero_sello();

				if($temporal > $numero){
					$numero = $temporal;
				}

			}

			return $numero + 1;
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
		public function shift(){
			return array_shift($this->sellos);
		}
		public function hasNext(){
			if (count($this->sellos) > 0 ){
				return true;
			}
			else{
				return false;
			}
		}

	}
?>