<?php

include_once("../includes/generic.connection.php");

class UpdateMany{
	private $tabla;
	private $campos;
	private $camposWhere;
	private $sentencia;

	private $PDOmysql;

	

	public function prepareUpdate($tabla,$campos, $camposWhere){
		$this->tabla = $tabla;
		$this->campos = $campos;
		$this->camposWhere = $camposWhere;

		$this->sentencia = 'update '. $tabla . ' set ';

		foreach ($this->campos as $key => $value) {

			$this->sentencia .= $key . ' = '. ':'. $key . ' ,';
		}

		$this->sentencia = substr( $this->sentencia , 0, -1);

		$this->sentencia .= 'where ';

		foreach ($this->camposWhere as $key => $value) {

			$this->sentencia .= $key . ' = '. ':'. $key . ' and ';
		}

		$this->sentencia = substr( $this->sentencia , 0, -4);

	}

	public function createUpdate(){
		
		$sql = $this->sentencia;

		$stmt = $this->PDOmysql->prepare($sql);

		foreach ($this->campos as $key => $value) {
			$valor = ":". $key;
			$stmt->bindValue($valor, $value);

		}

		foreach ($this->camposWhere as $key => $value) {
			$valor = ":". $key;
			$stmt->bindValue($valor, $value);
		}

        $stmt->execute();

	}

	public function beginUpdate(){
		$this->PDOmysql = consulta();
		$this->PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->PDOmysql->beginTransaction();
	}

	public function finishUpdate(){
		$this->PDOmysql->commit();
	}


}

?>