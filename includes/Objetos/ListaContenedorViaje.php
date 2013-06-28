<?php
include_once("../includes/generic.connection.php");
require_once("Contenedor.php");
require_once("Update.php");

	Class ListaContenedorViaje{
		private $flete;
		private $contenedores = array();

		function createListaContenedorViaje($flete,$contenedores){
			$this->flete = $flete;
			$this->contenedores = $contenedores;
		}

		#Obtiene los contenedores para el viaje de la base de datos. Inicializa las variables locales.
		#Se envia el numero de flete del cual se quieren obtener los contenedores.
		function getContenedoresDeViaje($flete){
			try{
			$flete = (int) $flete;

				$PDOmysql = consulta();
				$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = 'SELECT Contenedor_Viaje.Contenedor
						 FROM  Contenedor_Viaje
						 WHERE 
						 Contenedor_Viaje.Flete_idFlete = :flete
						  and Contenedor_Viaje.statusA = "Activo"';

				$stmt = $PDOmysql->prepare($sql);
	            $stmt->bindParam(':flete', $flete);
	            $stmt->execute();
	            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	            $this->flete = $flete;#Inicia la variable local flete, igual al flete que se señala-
	            $Listacontenedores = array(); #Crea una lista para almacenar los contenedores.
	            
	            foreach ($rows as $fila) { #Itera entre la consulta de la base de datos, cada ciclo, es un nuevo Contenedor.
	            	$contenedor = new Contenedor; # Se inicializa un objeto de la clase contenedor.

	            	$contenedor->getContenedorDeViaje($fila['Contenedor'], $flete);

	            	$Listacontenedores[] = $contenedor;
	            }

	            $this->contenedores = $Listacontenedores; #Inicia la variable local a los contenedores que se buscaron.


			} catch(PDOException $e){
				echo $e;
			}
		}

		#Este metodo inserta los contenedores del objeto a la base de datos.
		public function insertarContenedores(){
			#try{
			
				$PDOmysql = consulta();
				$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				#Itera entre el array Contenedores, para insertarlo uno por uno.
				foreach ($this->contenedores as $contenedor) {
				
					#Se comprueba si el contenedor esta en la base de datos.
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
								//Cada contenedor tiene un objeto ListaSellos.
								#Se manda a llamar al objeto, y este llama a su metodo insertar, para
								#añadir los sellos a la base de datos.
								#Esto se puede ya que cada contenedor conoce el flete al que pertenece.
					}

					else{
						$update = new Update;
						
						$camposUpdate =  array("statusA" => 'Activo');
						$camposWhereUpdate = array("Flete_idFlete" => $this->flete, "Contenedor" => $contenedor );

						$update->prepareUpdate("Contenedor_Viaje", $camposUpdate, $camposWhereUpdate);
						$update->createUpdate();
					}

					$listaSellos =  $contenedor->get_sellos();
					if($listaSellos){
						$listaSellos->insertar_sellos();
					}		

				}
			#}catch(Exception $e){

			#}

		}
	

		public function updateListaContenedores($arrayNuevosContenedores){
			$pilaContenedoresActualizar = array();
			$pilaContenedoresEliminar 	= array();
			$pilaContenedoresInsertar 	= array();

			$contenedoresActuales = array();
			//Obtiene los ID de los anteriores contenedores, para operaciones de comparacion.
			foreach ($this->contenedores as $contenedorViejo ) {
				$contenedoresActuales[] = $contenedorViejo->get_id();
			}

			for ($x =0; $x < count($arrayNuevosContenedores); $x++ ) {
				
				$id =  $arrayNuevosContenedores[$x]->get_id();

				for ($i=0; $i < count($contenedoresActuales) ; $i++) {
					if( $id == $contenedoresActuales[$i] ){

						$pilaContenedoresActualizar[] = $arrayNuevosContenedores[$x];
						//Como se sabe que los contenedores se actualizaran, 
						//se pasa a la pila de actualizacion.
						//El resto de los contenedores actuales se eliminaran.
						//El resto de los contenedores nuevos se insertaran.
						unset( $contenedoresActuales[$i] );
						unset( $arrayNuevosContenedores[$x] );
					}
				}

			}

			$pilaContenedoresInsertar = $arrayNuevosContenedores;
			$pilaContenedoresEliminar = $contenedoresActuales;

			$this->contenedores = $pilaContenedoresInsertar;
/*
			echo "Actualizar";
			print_r($pilaContenedoresActualizar);
			echo "Insertar";
			print_r($pilaContenedoresInsertar);
			echo "Eliminar";
			print_r($pilaContenedoresEliminar);
*/
			if($this->contenedores){
				$this->insertarContenedores();

			}

			if($pilaContenedoresEliminar){
				$this->eliminarContenedores($pilaContenedoresEliminar);
			}

			if($pilaContenedoresActualizar){
				$this->updateContenedores($pilaContenedoresActualizar );
			}
			
		}

		public function updateContenedores($contenedores){
			foreach ( $contenedores as $contenedorActual ) {

				$update = new Update;
				
				$camposUpdate =  array("WorkOrder" => $contenedorActual->get_workorder(), "Booking" => $contenedorActual->get_booking(),  );
				$camposWhereUpdate = array("Flete_idFlete" => $this->flete, "Contenedor" => $contenedorActual->get_id() );

				$update->prepareUpdate("Contenedor_Viaje", $camposUpdate, $camposWhereUpdate);
				$update->createUpdate();
			}
		}

		public function eliminarContenedores($contenedores){
			foreach ( $contenedores as $contenedorActual ) {
				$update = new Update;
				
				$camposUpdate =  array("statusA" => 'Eliminado');
				$camposWhereUpdate = array("Flete_idFlete" => $this->flete, "Contenedor" => $contenedorActual );

				$update->prepareUpdate("Contenedor_Viaje", $camposUpdate, $camposWhereUpdate);
				$update->createUpdate();
			}

			
		}

		public function __toString(){
        	return $this->id;
    	}

		function append($contenedor){
			array_push($this->contenedores,$contenedor);
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