<?php
include_once("../includes/generic.connection.php");

	Class Contenedor{
		private $id;
		private $flete;
		private $tipo;
		private $workorder;
		private $booking;
		private $sellos;

		function createContenedor($id,$flete,$tipo,$workorder,$booking,$sellos){
			$this->id = $id;
			$this->flete = $flete;
			$this->tipo = $tipo;
			$this->workorder = $workorder;
			$this->booking = $booking;
			$this->sellos = $sellos;
		}

		function getContenedorDeViaje($id,$flete){
			try{

				$PDOmysql = consulta();

				$sql = 'SELECT idContenedor FROM Contenedor WHERE Contenedor.idContenedor = :contenedor';

				$stmt = $PDOmysql->prepare($sql);
	            $stmt->bindParam(':contenedor', $id);
	            $stmt->execute();
	            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	            foreach ($rows as $fila) {

	            }
			} catch(PDOException $e){

			}
		}

		function insertarContenedor(){

		}
	}
?>