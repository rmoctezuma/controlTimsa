<?php

require_once("../includes/generic.connection.php");

class Semana{
	var $semana;
	var $anio;

	var $contenido;

	function Semana(){
	}

	function getRequest(){
		$PDOmysql = consulta();
		$rows = "";

		try{
			$sql = 'SELECT DAYOFYEAR(Flete.Fecha) dia
					FROM Flete  	
					WHERE
					WEEK(Flete.Fecha) = :semana
					and
					YEAR(Flete.Fecha) = :anio
					group by DAYOFYEAR(Flete.Fecha)';

			 $stmt = $PDOmysql->prepare($sql);
			 $stmt->bindParam(':semana', $this->semana);
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

		$this->contenido .='<div class="accordion-heading">
						      <a class="accordion-toggle" data-toggle="collapse" href="#semana'.$this->semana .'">
						        Semana '.$this->semana .'
						      </a>
						    </div>';

		$this->contenido .=	 '<div id="semana'. $this->semana .'" class="accordion-body collapse in">
						    		<div class="accordion-inner">';
		$this->contenido .= '<div class="accordion-group">';

		if($rows){
			foreach($rows as $fila) {
				$dia = new Dia;
				$dia->anio = $this->anio;
				$dia->dia  = $fila['dia'];

				$this->contenido .= $dia->getRequest();
			
			}
		}
		else{
			$this->contenido .= "<h4>No existen Fletes en esta semana</h4>";
		}
						    				

								    					    
		$this->contenido .=  '</div> </div>';	 
		$this->contenido .= '</div>';

		return $this->contenido;
	}
}

?>