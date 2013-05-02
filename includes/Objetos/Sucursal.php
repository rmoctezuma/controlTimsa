<?php

include_once("../includes/generic.connection.php");

Class Sucursal{
	private $id;
	private $nombreSucursal;
	private $calle;
	private $numero;
	private $colonia;
	private $localidad;
	private $ciudad;
	private $estado;
	private $telefono;
	private $status;
	private $fechaIngreso;
	private $fechaDeprecated;
	private $lat;
	private $long;

	#Objetos Foraneos de la sucursal.
	private $Cliente;
	private $Cuota;

	function createSucursal(){
		
	}


	function getSucursalFromID($id){
		try{

			$PDOmysql = consulta();

			$sql = 'SELECT * FROM clientedireccion  WHERE clientedireccion.Sucursal = :sucursal';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':sucursal', $id);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $fila) {
            	$this->id = $fila['Sucursal'];
				$this->nombreSucursal= $fila['NombreSucursal'];
				$this->calle = $fila['Calle'];
				$this->numero = $fila['Numero'];
				$this->colonia = $fila['Colonia'];
				$this->localidad = $fila['Localidad'];
				$this->ciudad = $fila['Ciudad'];
				$this->estado = $fila['Estado'];
				$this->telefono = $fila['Telefono'];
				$this->status = $fila['StatusA'];
				$this->fechaIngreso = $fila['fecha_ingreso'];
				$this->fechaDeprecated = $fila['fecha_deprecated'];
				$this->lat = $fila['Lat'];
				$this->long = $fila['Lon'];

				#Objetos Foraneos de la sucursal.	
				$this->Cliente = new Cliente;
				$this->Cliente->incializarClienteConIdentificador($fila['Cliente_idCliente']);
				$this->Cuota = new Cuota;
				$this->Cuota->getCuotaFromID( $fila['Cuota_idCuota']);
            }

		} catch(PDOException $e){

		}

	}

	function getID(){
		return $this->id;
	}

	function setID($id){
		$this->id = $id;
	}

	function get_nombreSucursal(){
		return $this->nombreSucursal;
	}

	function set_nombreSucursal($nombreSucursal){
		$this->nombreSucursal = $nombreSucursal;
	}

	function get_calle(){
		return $this->calle;
	}

	function set_calle($calle){
		$this->calle = $calle;
	}

	function get_numero(){
		return $this->numero;
	}

	function set_numero($numero){
		$this->numero = $numero;
	}
	function get_colonia(){
		return $this->colonia;
	}

	function set_colonia($colonia){
		$this->colonia = $colonia;
	}
	function get_localidad(){
		return $this->localidad;
	}

	function set_localidad($localidad){
		$this->localidad = $localidad;
	}
	function get_ciudad(){
		return $this->ciudad;
	}

	function set_ciudad($ciudad){
		$this->ciudad = $ciudad;
	}
	function get_estado(){
		return $this->estado;
	}

	function set_estado($estado){
		$this->estado = $estado;
	}
	function get_telefono(){
		return $this->telefono;
	}

	function set_telefono($telefono){
		$this->telefono = $telefono;
	}
	function get_status(){
		return $this->status;
	}

	function set_status($status){
		$this->status = $status;
	}
	function get_fechaIngreso(){
		return $this->fechaIngreso;
	}

	function set_fechaIngreso($fechaIngreso){
		$this->fechaIngreso = $fechaIngreso;
	}
	function get_fechaDeprecated(){
		return $this->fechaDeprecated;
	}

	function set_fechaDeprecated($fechaDeprecated){
		$this->fechaDeprecated = $fechaDeprecated;
	}
	function get_lat(){
		return $this->lat;
	}

	function set_lat($lat){
		$this->lat= $lat;
	}
	function get_long(){
		return $this->long;
	}

	function set_long($long){
		$this->long = $long;
	}

	function get_Cuota(){
		return $this->Cuota;
	}

	function set_Cuota($Cuota){
		$this->Cuota = $Cuota;
	}

	function get_Cliente(){
		return $this->long;
	}

	function set_Cliente($Cliente){
		$this->Cliente = $Cliente;
	}



}

?>