<?php

include('../includes/generic.connection.php');

if(isset($_POST) && !empty($_POST)){

	$economico = $_POST['economico'];
	$action = $_POST['action'];
	$contenido = "";

	if($action == "economico"){

	try{
		$PDOmysql = consulta();
		$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = 'SELECT distinct Economico.Economico, Economico.Placas, Economico.StatusA status,
			Socio.idSocio
            from
            Economico, Socio, VehiculoDetalle
			where 
			VehiculoDetalle.Socio = Socio.idSocio
			and
			VehiculoDetalle.Economico = Economico.Economico
			and
            VehiculoDetalle.Economico LIKE ":economico%"';

		$nwestmt = $PDOmysql->prepare($sql);
        $nwestmt->bindParam(':economico',$economico);
        $nwestmt->execute();
        $nwerows = $nwestmt->fetchAll(PDO::FETCH_ASSOC);

        $contenido .= '<div id="botonGroupEconomico" class="btn-group" data-toggle="buttons-radio">';
        $Contador = 0;

          foreach ($nwerows as $fila) {
              if($fila['status'] == 'Libre'){
                if($Contador == 3) {$contenido .= '<br>';}
                $Contador += 1;
                  $contenido .= '<button type="button" val="'.$fila['idSocio'].'" title="'.$fila['Placas'].'" class="btn btn-large " data-toggle="button">'.$fila['Economico']. '</button>';
              }
              else{
                if($Contador == 3) {$contenido .= '<br>';}
                $Contador += 1;
                 $contenido .= '<button type="button" val="'.$fila['idSocio'].'" title="'.$fila['Placas'].'" class="btn btn-large disabled " disabled = "disabled" data-toggle="button">'.$fila['Economico']. '</button>';
              }
          }

          $contenido .= '<div>';
	}
	catch(PDOException $e){

	}

}

}

$resultados  = array('contenido' => $contenido );
echo json_encode($resultados);
?>