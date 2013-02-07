<?php

$respuestaOK = true;
$cuota = "";
$tarifa = "";
$lugar = "";

if(isset($_POST) && !empty($_POST)){
	$mysqli = consulta();

	$sql = 'select CuotaDetalle.numero num, CuotaDetalle.Tarifa tarifa, Cuota.Lugar lugar
                  from
                  CuotaDetalle,Cuota
                  where
                  CuotaDetalle.Trafico = "'. $_POST['trafico'] .'"
                  and
                  CuotaDetalle.TipoViaje = "'. $_POST['viaje'] .'"
                  and
                  CuotaDetalle.Cuota_idCuota ='. $_POST['value'].'
                  and
                  Cuota.idCuota = '. $_POST['value'] ;


	foreach ($mysqli -> query($sql) as $fila) {
		$respuestaOK = false;
    $cuota .= $fila['num'];
    $tarifa .= $fila['tarifa'];
    $lugar .= $fila['lugar'];
	}

}

$salidaJson = array("respuesta" => $respuestaOK,
          					"cuota" => $cuota,
          					"tarifa" => $tarifa,
          					"lugar" => $lugar
                    );

echo json_encode($salidaJson);

      function consulta(){
        try {
              $mysqli = new PDO('mysql:host=www.timsalzc.com;dbname=timsalzc_ControlTimsa;charset=utf8', 'timsalzc_Raul', 'f203e21387');
              $respuestaOK = false;
                } catch(PDOException $ex) {
                    echo "An Error occured!"; //user friendly message
                    echo $ex->getMessage();
                    $respuestaOK = false;
          }
          return $mysqli;
      }

?>