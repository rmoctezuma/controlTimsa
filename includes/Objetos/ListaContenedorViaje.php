<?php
include_once("../includes/generic.connection.php");
require_once("Contenedor.php");

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

				$PDOmysql = consulta();

				$sql = 'SELECT Contenedor_Viaje.Contenedor
						 FROM  Contenedor_Viaje
						 WHERE Contenedor_Viaje.Flete_idFlete = :flete';

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
				echo "Error";
			}
		}

		#Este metodo inserta los contenedores del objeto a la base de datos.
		public function insertarContenedores(){
			#try{

				$PDOmysql = consulta();
				$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				#Itera entre el array Contenedores, para insertarlo uno por uno.
				for ($i=0; $i < count($this->contenedores); $i++) {
					$contenedor = $this->contenedores[$i]; #obtiene un contenedor.

					/*echo $contenedor->get_id();
					echo $contenedor->get_flete();
					echo $contenedor->get_tipo();
					echo $contenedor->get_workorder();
					echo $contenedor->get_booking();
					*/

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
						$listaSellos =  $contenedor->get_sellos();
						$listaSellos->insertar_sellos();

				}
			#}catch(Exception $e){

			#}
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