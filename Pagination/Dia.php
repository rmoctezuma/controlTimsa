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
			$sql = 'SELECT idFlete id, statusA status
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
		$date = $this->getDateFromDay($this->dia, $this->anio);

		$this->contenido .='<div class="accordion-heading">
						      <a class="accordion-toggle" data-toggle="collapse" href="#dia'.$this->dia .'">
						         	'.$date->format('j F Y') .'
						      </a>
						    </div>';

		$this->contenido .=	 '<div id="dia'. $this->dia .'" class="accordion-body collapse">
						    		<div class="accordion-inner">';

		foreach($rows as $fila) {
			$this->contenido.= $fila['id'];
			$this->contenido.= $fila['status'];
			$this->contenido.= $this->anio;
			$this->contenido.= ' <br>';
		}

		$this->contenido.= '</div>';
		$this->contenido.= '</div>';

		return $this->contenido;
	}

	function getDateFromDay($dayOfYear, $year) {
		  $date = DateTime::createFromFormat('z Y', strval($dayOfYear-1) . ' ' . strval($year));
		  return $date;
	}


}

?>