<?php
	
	include('../includes/generic.connection.php');

	$PDOmysql = consulta();
	$result = "";

	if(isset($_POST) && !empty($_POST)){
		$numero = $_POST['value'];

		try {
			$PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$sql = 'SELECT distinct CuotaDetalle.Tarifa tarifa , CuotaDetalle.Trafico trafico, CuotaDetalle.TipoViaje tipo
                          from CuotaDetalle
                          where statusA = "Activo"
                          and  CuotaDetalle.Cuota_idCuota = :numcuota';

                  $nwestmt = $PDOmysql->prepare($sql);
                  $nwestmt->bindParam(':numcuota',$numero);
                  $nwestmt->execute();
                  $nwerows = $nwestmt->fetchAll(PDO::FETCH_ASSOC);

                    $ImpSen ="";
                    $ReuSen ="";
                    $ExpSen ="";
                    $ImpFull ="";
                    $ReuFull ="";
                    $ExpFull ="";

                  if(! ($nwerows != null)){
                    $result = false;
                  }
                  else{

                    foreach ($nwerows as $nwefila){

                      switch ($nwefila['tipo']) {
                        case 'Sencillo':
                            switch ($nwefila['trafico']) {
                              case 'Exportacion':
                                 $ExpSen = $nwefila['tarifa'];
                                break;
                              case 'Importacion':
                                $ImpSen = $nwefila['tarifa'];
                                break;
                              case 'Reutilizado':
                                $ReuSen = $nwefila['tarifa'];
                                break;
                            }
                          break;

                        case 'Full':
                          switch ($nwefila['trafico']) {
                                case 'Exportacion':
                                  $ExpFull = $nwefila['tarifa'];
                                  break;
                                case 'Importacion':
                                  $ImpFull = $nwefila['tarifa'];
                                  break;
                                case 'Reutilizado':
                                  $ReuFull = $nwefila['tarifa'];
                                  break;
                              }
                          break;
                      }
                    }
                      $result .= '<table class="table table-condensed">';
                      $result .='<thead>
                                    <tr>
                                      <th colspan=3 > Sencillo </th>
                                      </tr>
                                      <tr>
                                        <th> Importacion </th>
                                        <th> Exportacion </th>
                                        <th> Reutilizado </th>
                                      </tr>      
                                  </thead>';
                        $result .= '<tbody>';
                        $result .= '<tr>';
                        $result .=  '<td>'. $ImpSen.'</td>';
                        $result.= '<td>'. $ExpSen.'</td>';
                        $result.= '<td>'.$ReuSen.'</td>';
                        $result.= '</tr>';
                        $result .= '</tbody>';
                        $result.= '</table>';

                        $result .= '<table class="table table-condensed">';
                        $result .='<thead>
                                      <tr>
                                        <th colspan=3> Full</th>
                                      </tr>
                                      <tr>
                                        <th> Importacion </th>
                                        <th> Exportacion </th>
                                        <th> Reutilizado </th>
                                      </tr>
                                    </thead>';
                       $result .= '<tbody> <tr>';
                       $result.= '<td>'.$ImpFull.'</td>';
                       $result.= '<td>'.$ExpFull.'</td>';
                       $result.= '<td>'.$ReuFull.'</td>';
                       $result.= '</tr>';
                       $result .= '</tbody>';
                       $result.= '</table>';
                   }

		 } catch(PDOException $ex) {
		    //Something went wrong rollback!
		    $PDOmysql->rollBack();
		    echo $ex->getMessage();
		    $respuestaOK = false;
        header('Location: http://control.timsalzc.com/Timsa/html/clientes.php?resultado=incorrecto');
		}
	}

	$resultados = array('resultado' => $result );
	echo json_encode($resultados);

?>