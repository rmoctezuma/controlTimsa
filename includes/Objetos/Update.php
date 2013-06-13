<?php

include_once("../includes/generic.connection.php");

class Update{
	private $tabla;
	private $campos;
	private $camposWhere;
	private $sentencia;

	public function prepareUpdate($tabla,$campos, $camposWhere){
		$this->tabla = $tabla;
		$this->campos = $campos;
		$this->camposWhere = $camposWhere;

		$this->$sentencia = 'update '. $tabla . 'set';
		$keys = array_keys($this->campos);

		while(count($keys) >= 0){
			$campo = array_shift($keys);
			$this->sentencia .= $campo . ' = '. ':'. $campo . ' ,';
		}

		$this->sentencia = substr( $this->sentencia , 0, -1);

		$this->sentencia .= 'where ';

		$wherekeys = array_keys($this->camposWhere);

		while(count($wherekeys) >= 0){
			$campo = array_shift($wherekeys);
			$this->sentencia .= $campo . ' = '. ':'. $campo . ' and';
		}

		$this->sentencia = substr( $this->sentencia , 0, -3);

		echo $this->sentencia;
	}

	public function createUpdate(){
		$PDOmysql = consulta();
		$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = $this->sentencia;

		$stmt = $PDOmysql->prepare($sql);

		foreach ($this->campos as $key => $value) {
			$valor = ":". $key;

			$stmt->bindParam($valor, $value);
		}

		foreach ($this->camposWhere as $key => $value) {
			$valor = ":". $key;

			$stmt->bindParam($valor, $value);
		}

        $stmt->execute();

	}





}

?>