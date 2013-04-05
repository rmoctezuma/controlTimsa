<?php

include('../includes/generic.connection.php');

if(isset($_POST) && !empty($_POST)){

	$economico = $_POST['economico'];
	$action = $_POST['action'];
	$contenido = "";
  $nombreSocio = "";

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
            VehiculoDetalle.Economico LIKE :economico';

            $economico  = "%$economico%";

		$nwestmt = $PDOmysql->prepare($sql);
        $nwestmt->bindParam(':economico',$economico, PDO::PARAM_STR);
        $nwestmt->execute();
        $nwerows = $nwestmt->fetchAll(PDO::FETCH_ASSOC);

        $contenido .= '<div id="botonGroupEconomicoViaNumeroEconomico" class="btn-group" data-toggle="buttons-radio">';
        $Contador = 0;
        $nombreSocio = "incorrecto";

          foreach ($nwerows as $fila) {
            $nombreSocio = "correcto";
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
    $contenido .= $e->getMessage();
	}

}

    if($action == "buscarEconomico"){
        $socio = $_POST['Socio'];

        try{
          $PDOmysql = consulta();
          $PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $sql = 'SELECT distinct Operador.Eco operador,Operador.Nombre nombre, Operador.ApellidoP apellidop, Operador.ApellidoM apellidom, Operador.statusA status,
                         Socio.idSocio, Socio.Nombre
                  from
                  Operador, VehiculoDetalle,Socio
                  where
                  Operador.Eco = VehiculoDetalle.Operador
                  and
                  VehiculoDetalle.Socio = :socio
                  and
                  VehiculoDetalle.Socio = Socio.idSocio
                  and
                  Operador.statusA <> "Deprecated"
                  and
                  VehiculoDetalle.Economico = :economico';

          $nwestmt = $PDOmysql->prepare($sql);
              $nwestmt->bindParam(':economico',$economico);
              $nwestmt->bindParam(':socio',$socio);
              $nwestmt->execute();
              $nwerows = $nwestmt->fetchAll(PDO::FETCH_ASSOC);

            $contenido .= ' <h4> Operadores que han conducido este economico </h4>';
            $contenido .= ' <div id= "RadioOperadores">';

          foreach ($nwerows as $fila) {
            $nombreSocio = $fila['Nombre'];

            if( $fila['status'] == 'Libre'){

              $contenido .= '<label class="radio">
                                <input type="radio" name="optionsRadios" value="'.$fila['operador'].'">
                                '.$fila['nombre']  .  $fila['apellidop'] .  $fila['apellidom'] .'
                              </label>';
               }

               else{
                                $contenido .= '<label class="radio">
                                                <input type="radio" disabled="disabled" name="optionsRadios" value="'.$fila['operador'].'">
                                                '.$fila['nombre']  .  $fila['apellidop'] .  $fila['apellidom'] .'
                                              </label>';
              }

          $contenido .= '</div>';
          }

      }catch(PDOException $e){
        $contenido .= $e->getMessage();
      }
}

}

$resultados  = array('contenido' => $contenido,
                     'socio' => $nombreSocio );
echo json_encode($resultados);
?>