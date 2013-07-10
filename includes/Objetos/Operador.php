<?php
include_once("../includes/generic.connection.php");

Class Operador{
	private $id;
	private $nombre;
	private $apellidop;
	private $apellidom;
	private $RC;
	private $curp;
	private $fechaIngreso;
	private $status;
	private $fecha_deprecated;
	private $telefono;
	private $imagen;

	function createOperador($id,$nombre,$apellidop,$apellidom,$RC,$curp,$fechaIngreso,$status,$fecha_deprecated,$telefono,$imagen){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->apellidop = $apellidop;
		$this->apellidom = $apellidom;
		$this->RC = $RC;
		$this->curp = $curp;
		$this->fechaIngreso = $fechaIngreso;
		$this->status = $status;
		$this->fecha_deprecated = $fecha_deprecated;
		$this->telefono = $telefono;
		$this->imagen = $imagen;
	}

	public function getOperadorFromID($id){
		try{

			$PDOmysql = consulta();

			$sql = 'SELECT * FROM Operador WHERE Operador.Eco = :operador';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':operador', $id);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $fila) {
	             $this->id  = $id;
	             $this->nombre = $fila['Nombre'];
	             $this->apellidop = $fila['ApellidoP'];
	             $this->apellidom = $fila['ApellidoM'];
	           	 $this->RC = $fila['RC'];
	             $this->curp = $fila['CURP'];
	             $this->fechaIngreso = $fila['fecha_ingreso'];
	             $this->status = $fila['statusA'];
	             $this->fecha_deprecated = $fila['fecha_deprecated'];
	             $this->telefono = $fila['Telefono'];
	             $this->imagen = $fila['rutaImagen'];
            }
		} catch(PDOException $e){

		}
	}

	public function __toString(){
        return $this->id;
    }

	public function get_id(){
		return $this->id;
	}
	public function set_id($id){
		$this->id = $id;	
	}
	public function get_nombre(){
		return $this->nombre;
	}
	public function set_nombre($nombre){
		$this->nombre = $nombre;	
	}
	public function get_apellidop(){
		return $this->apellidop;
	}
	public function set_apellidop($apellidop){
		$this->apellidop = $apellidop;	
	}
	public function get_apellidom(){
		return $this->apellidom;
	}
	public function set_apellidom($apellidom){
		$this->apellidom = $apellidom;	
	}
	public function get_RC(){
		return $this->RC;
	}
	public function set_RC($RC){
		$this->RC = $RC;	
	}
	public function get_curp(){
		return $this->curp;
	}
	public function set_curp($curp){
		$this->curp = $curp;	
	}
	public function get_fechaIngreso(){
		return $this->fechaIngreso;
	}
	public function set_fechaIngreso($fechaIngreso){
		$this->fechaIngreso = $fechaIngreso;	
	}
	public function get_status(){
		return $this->status;
	}
	public function set_status($status){
		$this->status = $status;	
	}
	public function get_fecha_deprecated(){
		return $this->RC;
	}
	public function set_fecha_deprecated($fecha_deprecated){
		$this->fecha_deprecated = $fecha_deprecated;	
	}
	public function get_telefono(){
		return $this->telefono;
	}
	public function set_telefono($telefono){
		$this->telefono = $telefono;	
	}
	public function get_imagen(){
		return $this->imagen;
	}
	public function set_imagen($imagen){
		$this->imagen = $imagen;	
	}

}