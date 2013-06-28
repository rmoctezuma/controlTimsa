<?php
include_once("../includes/generic.connection.php");
require_once("ListaSellos.php");
require_once("UpdateMany.php");

	Class Contenedor{
		private $id;
		private $flete;
		private $tipo;
		private $workorder;
		private $booking;
		private $sellos;

		function createSampleContenedor($id,$flete,$tipo,$workorder,$booking){
			$this->id = $id;
			$this->flete = $flete;
			$this->tipo = $tipo;
			$this->workorder = $workorder;
			$this->booking = $booking;
		}

		function createContenedor($id,$flete,$tipo,$workorder,$booking,$sellos){
			$this->id = $id;
			$this->flete = $flete;
			$this->tipo = $tipo;
			$this->workorder = $workorder;
			$this->booking = $booking;
			$this->sellos = $sellos;

			$this->sellos->set_flete($this->get_flete());
			$this->sellos->set_contenedor($this->get_id());
		}

		function getContenedorDeViaje($id,$flete){
			try{
			
			$id =  $id;
			$flete = (int) $flete;
			

				$PDOmysql = consulta();
				$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = 'SELECT Contenedor.idContenedor,Contenedor.Tipo, Contenedor_Viaje.WorkOrder,
								Contenedor_Viaje.Booking
						 FROM Contenedor, Contenedor_Viaje
						 WHERE Contenedor.idContenedor = :contenedor
						 and Contenedor_Viaje.Contenedor = Contenedor.idContenedor
						 and Contenedor_Viaje.Flete_idFlete = :flete
						 and Contenedor_Viaje.statusA = "Activo"';

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


			} catch(Exception $e){
				echo $e;
			}
		}

		public function modificarEstadoContenedor($contenedor){

			$PDOmysql = consulta();
			$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$sql = 'select idContenedor from Contenedor where idContenedor = :contenedor';
			$stmt = $PDOmysql->prepare($sql);
			$stmt->bindParam(':contenedor', $contenedor->get_id());
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			#La variable respuesta comprueba si existe o no el contendor.
			$respuesta =  $stmt->rowCount() ? true : false;
			#Si respuesta es que no existe el contenedor aun en la base de datos.
			if(! $respuesta){
				#Inserta el contenedor.
				$sql = 'insert into Contenedor(idContenedor,Tipo) values(:contenedor, :tipo);';
				$stmt = $PDOmysql->prepare($sql);
				$stmt->bindParam(':contenedor', $contenedor->get_id()); #get_id() y get_tipo()
				$stmt->bindParam(':tipo', $contenedor->get_tipo());		#son metodos de la clase contenedor.
				$stmt->execute();
			}

			if($this->get_id() == $contenedor->get_id()){
				$camposUpdate  = array('Contenedor' => $contenedor->get_id(),
										'Booking' => $contenedor->get_booking(),
										'WorkOrder' => $contenedor->get_workorder()
									  );

				 $this->modificarDetalleContenedor($camposUpdate);
			}
			else{

				$this->modificarContenedor($contenedor);
			}

		}

		public function modificarContenedor( $contenedor ){

			

			$update = new Update();
			$camposUpdate  = array('statusA' => 'Eliminado' );
			
			$camposWhereUpdate = array("NumFlete"      => $this->flete, 
										"Contenedor"    => $this->id
									  );

			$update->prepareUpdate("ContenedorSellos", $camposUpdate, $camposWhereUpdate);
			$update->createUpdate();

			$update = new Update();

			$camposWhereUpdate = array("Flete_idFlete"      => $this->flete, 
										"Contenedor"   	    => $this->id
									  );

			$update->prepareUpdate("Contenedor_Viaje", $camposUpdate, $camposWhereUpdate);
			$update->createUpdate();


			$PDOmysql = consulta();
			$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			
			$sql = 'SELECT Flete_idFlete, Contenedor 
					from Contenedor_Viaje 
					where 
					Flete_idFlete = :flete
					and
					Contenedor = :contenedor';

			$stmt = $PDOmysql->prepare($sql);
			$stmt->bindParam(':contenedor', $contenedor->get_id());
			$stmt->bindParam(':flete', $this->flete);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			#La variable respuesta comprueba si existe o no el contendor.
			$respuesta =  $stmt->rowCount() ? true : false;

			if(! $respuesta){
				#Incicializa el viaje para el flete, asignando contenedores al flete.
				$sql = 'insert into Contenedor_Viaje(WorkOrder,Booking,Flete_idFlete, Contenedor) values(:workorder, :booking, :flete, :contenedor);';
				$stmt = $PDOmysql->prepare($sql);
				$stmt->bindParam(':workorder', $contenedor->get_workorder());
				$stmt->bindParam(':booking', $contenedor->get_booking());
				$stmt->bindParam(':flete', $contenedor->get_flete());
				$stmt->bindParam(':contenedor', $contenedor->get_id());
				$stmt->execute();
			}

			$listaSellos =  $this->get_sellos();
			if($listaSellos){
				$listaSellos->set_contenedor($contenedor->get_id());
				$listaSellos->insertar_sellos();
			}		

		}

		public function modificarDetalleContenedor($camposUpdate){
			$update = new UpdateMany();
						$update->beginUpdate();

						$camposWhereUpdate = array(
													"NumFlete"      => $this->flete, 
													"Contenedor"    => $this->id,
													"statusA"		=> "Activo"
												  );


						$camposUpdates  = array('Contenedor' => $camposUpdate['Contenedor'] );
						$update->prepareUpdate("ContenedorSellos", $camposUpdates, $camposWhereUpdate);
						$update->createUpdate();


						$camposWhereUpdate = array(
													"Flete_idFlete" => $this->flete, 
													"Contenedor"    => $this->id,
													"statusA"		=> "Activo"
												  );

						$update->prepareUpdate("Contenedor_Viaje", $camposUpdate, $camposWhereUpdate);
						$update->createUpdate();

						$update->finishUpdate();
		}


		public function __toString(){
			$data = $this->id . "";
        	return $data;
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
		public function set_workorder($workorder){
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