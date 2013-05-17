<?php
include_once("../includes/generic.connection.php");
require_once("ListaSellos.php");

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

				$sql = 'SELECT Contenedor.idContenedor,Contenedor.Tipo, Contenedor_Viaje.WorkOrder,
								Contenedor_Viaje.Booking
						 FROM Contenedor, Contenedor_viaje
						 WHERE Contenedor.idContenedor = :contenedor
						 and Contenedor_viaje.Contenedor = Contenedor.idContenedor
						 and Contenedor_viaje.Flete_idFlete = :flete';

				$stmt = $PDOmysql->prepare($sql);
	            $stmt->bindParam(':contenedor', $id);
	            $stmt->bindParam(':flete', $flete);
	            $stmt->execute();
	            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	            $this->id = $id;
	            $this->flete = $flete;

	            foreach ($rows as $fila) {

	            	$this->tipo = $fila['Tipo'];
	            	$this->workorder = $fila['WorkOrder'];
	            	$this->booking = $fila['Booking'];

	            }

	            $this->sellos = new ListaSellos;
	            $this->sellos->getSellosDeContenedor($id,$flete);


			} catch(PDOException $e){
				echo "Error";
			}
		}

		public function __toString(){
			$data = $this->id . "";
        	return $data;
    	}

		function insertarContenedor(){

		}

		public function get_id(){
			return $this->id;
		}
		public function set_id($id){
			 $this->id = $id;
		}

		public function get_flete(){
			return $this->flete;		
		}
		public function set_flete(){
			$this->flete = $flete;
		}

		public function get_tipo(){
			return $this->tipo;
		}
		public function set_tipo(){
			$this->tipo = $tipo;	
		}

		public function get_workorder(){
			return $this->workorder;
		}
		public function set_workorder(){
			$this->workorder = $workorder;
		}

		public function get_booking(){
			return $this->booking;
		}
		public function set_booking(){
			$this->booking = $booking;
		}

		public function get_sellos(){
			return $this->sellos;
		}
		public function set_sellos(){
			$this->sellos = $sellos;
		}

	}
?>