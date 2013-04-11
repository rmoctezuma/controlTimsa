<?php

require_once("../includes/generic.connection.php");

class Dia{
	var $anio;
	var $dia;

	var $contenido;

	function Dia(){
	}

	function getRequest(){
		$PDOmysql = consulta();
		$rows = "";

		try{

			$sql = 'SELECT idFlete, Fecha
					FROM Flete  	
					WHERE
					DAYOFYEAR(Flete.Fecha) = :dia
					and
					YEAR(Flete.Fecha) = :anio
					ORDER BY idFlete';

			$stmt = $PDOmysql->prepare($sql);
			 $stmt->bindParam(':dia', $this->dia);
			 $stmt->bindParam(':anio', $this->anio);
			 $stmt->execute();
			 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			}catch(PDOException $ex){
				$this->contenido .= $ex;
				$rows = "ERROR";
			}

		 return $this->formattedRequest($rows);
	}

	function formattedRequest($rows){
		foreach($rows as $fila) {
			$this->contenido.= $fila['idFlete'];
		}
		return $this->contenido;
	}
}

?>