<?php

require_once("../includes/generic.connection.php");

class Mes{
	var $anio;
	var $mes;

	var $contenido;

	function Dia(){
	}

	function getRequest(){
		$PDOmysql = consulta();
		$rows = "";

		try{

			$sql = 'SELECT WEEK(Flete.Fecha) semana
					FROM Flete
					WHERE
					MONTH(Flete.Fecha) = :mes
					and
					YEAR(Flete.Fecha) = :anio
					group by WEEK(Flete.Fecha)';

			$stmt = $PDOmysql->prepare($sql);
			 $stmt->bindParam(':mes', $this->mes);
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
		$mesActual = $this->getMonthFromNumber($this->mes, $this->anio);

		$this->contenido .='<div class="accordion-heading">
						      <a class="accordion-toggle" data-toggle="collapse" href="#'.$this->mes .'">
						        '.$mesActual->format('F') .'
						      </a>
						    </div>';

		$this->contenido .=	 '<div id="'. $this->mes .'" class="accordion-body collapse in">
						    		<div class="accordion-inner">';
		$this->contenido .= '<div class="accordion-group">';

		if($rows){
			foreach($rows as $fila) {
				$semana = new Semana;
				$semana->anio   = $this->anio;
				$semana->semana = $fila['semana'];

				$this->contenido .= $semana->getRequest();
			}
		}
		else{
			$this->contenido .= "<h4>No existen Fletes este mes</h4>";
		}
		
		$this->contenido .=  '</div> </div>';	 
		$this->contenido .= '</div>';

		return $this->contenido;
	}

	function getMonthFromNumber($month, $anio) {
		  $date = DateTime::createFromFormat('m Y', strval($month) . ' ' . strval($anio));
		  return $date;
	}
}

?>