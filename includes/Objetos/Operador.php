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

	function Operador($id,$nombre,$apellidop,$apellidom,$RC,$curp,$fechaIngreso,$status,$fecha_deprecated,$telefono,$imagen){
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

	function get_id(){
		return $this->id;
	}
	function set_id($id){
		$this->id = $id;	
	}
	function get_nombre(){
		return $this->nombre;
	}
	function set_nombre($nombre){
		$this->nombre = $nombre;	
	}
	function get_apellidop(){
		return $this->apellidop;
	}
	function set_apellidop($apellidop){
		$this->apellidop = $apellidop;	
	}
	function get_apellidom(){
		return $this->apellidom;
	}
	function set_apellidom($apellidom){
		$this->apellidom = $apellidom;	
	}
	function get_RC(){
		return $this->RC;
	}
	function set_RC($RC){
		$this->RC = $RC;	
	}
	function get_curp(){
		return $this->curp;
	}
	function set_curp($curp){
		$this->curp = $curp;	
	}
	function get_fechaIngreso(){
		return $this->fechaIngreso;
	}
	function set_fechaIngreso($fechaIngreso){
		$this->fechaIngreso = $fechaIngreso;	
	}
	function get_status(){
		return $this->status;
	}
	function set_status($status){
		$this->status = $status;	
	}
	function get_fecha_deprecated(){
		return $this->RC;
	}
	function set_fecha_deprecated($fecha_deprecated){
		$this->fecha_deprecated = $fecha_deprecated;	
	}
	function get_telefono(){
		return $this->telefono;
	}
	function set_telefono($telefono){
		$this->telefono = $telefono;	
	}
	function get_imagen(){
		return $this->imagen;
	}
	function set_imagen($imagen){
		$this->imagen = $imagen;	
	}

}