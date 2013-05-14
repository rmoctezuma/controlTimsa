<?php

Class ListaSellos{
	private $sello;
	private $numero_sello;
	private $fecha_sellado;

	function createSello($sello,$numero_sello,$fecha_sellado){
		$this->sello = $sello;
		$this->numero_sello = $numero_sello;
		$this->fecha_sellado = $fecha_sellado;
	}

	public function set_sello($sello){
		$this->sello = $sello;
	}

	public function get_sello(){
		return $this->sello;
	}

	public function set_numero_sello($numero){
		$this->numero_sello = $numero;
	}

	public function get_numero_sello(){
		return $this->numero_sello;
	}

	public function set_fecha_sellado($fecha_sellado){
		$this->fecha_sellado = $fecha_sellado;
	}

	public function get_fecha_sellado(){
		return $this->fecha_sellado;
	}
?>