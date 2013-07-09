<?php

include_once("../includes/generic.connection.php");

class Insert{
	private $tabla;
	private $campos;
	private $sentencia;

	public function prepareInsert($tabla, $campos){
		$this->tabla = $tabla;
		$this->campos = $campos;

		$this->sentencia = 'INSERT INTO '. $tabla . ' ( ';

		foreach ($this->campos as $key => $value) {

			$this->sentencia .= $key . ' ,';
		}

		$this->sentencia = substr( $this->sentencia , 0, -1);

		$this->sentencia .= ' ) VALUES (';

		foreach ($this->campos as $key => $value) {

			$this->sentencia .= ':'. $key . ',';
		}

		$this->sentencia = substr( $this->sentencia , 0, -1);
		$this->sentencia .= ')';

	}

	public function createUpdate(){
		$PDOmysql = consulta();
		$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = $this->sentencia;

		$stmt = $PDOmysql->prepare($sql);

		foreach ($this->campos as $key => $value) {
			$valor = ":". $key;
			$stmt->bindValue( $valor, $value );
		}

        $stmt->execute();

        $respuesta =  $stmt->rowCount() ? true : false;
	}

}

?>