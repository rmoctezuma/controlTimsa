<?php

$resultado = "";

include('../includes/generic.connection.php');

$resultado = "";
$tablaAppend = "";

$statusTipo2 = array("Libre" => "label label-info",
                     "Ocupado" => "label label-warning",
                      "Indispuesto" => "label label-success",
                      "Fallido" => "label label-important"
                     );


if(isset($_POST) && !empty($_POST)){
	$economico = $_POST['economico'];
	$operador = $_POST['operador'];
	$socio = $_POST['socio'];
	$action = $_POST['action'];

	if($action == 'agregarOperador'){
		$sql = 'insert into VehiculoDetalle(Operador,Economico,Socio) values(:operador,:economico, :socio)';
		$PDOmysql = consulta();

		try{
	        $PDOmysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt = $PDOmysql->prepare($sql);
			$stmt->bindParam(':operador', $operador);
			$stmt->bindParam(':economico', $economico);
			$stmt->bindParam(':socio', $socio);
			$stmt->execute();

			$resultado .= 'Exito en la Operacion, operador agregado';

			$sql = 'select Operador.Eco Economico, Operador.Nombre, Operador.ApellidoP, Operador.ApellidoM, Operador.statusA
					from Operador,VehiculoDetalle
					where
					VehiculoDetalle.Operador = Operador.Eco
					and
					VehiculoDetalle.Economico = :economico ';
			$stmt = $PDOmysql->prepare($sql);
			$stmt->bindParam(':economico', $economico);
			$stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

             $tablaAppend .= '<table id="tableOperadores" class="table table-condensed span5">';
			 $tablaAppend .= '<thead>';
			 $tablaAppend .= '<tr>  <th>Operador </th> <th>Nombre </th> <th> Status </th>  </tr>';
			 $tablaAppend .= '</thead>';
			 $tablaAppend .= '<tbody>';

            foreach ($rows as $fila) {
            	$tablaAppend .= '<tr>';
            	$tablaAppend .= '<td> '. $operador .' </td>';
            	$tablaAppend .=  '<td>'. $fila['Nombre'] . ' ' . $fila['ApellidoP'] . ' ' . $fila['ApellidoM'] . '</td>';
            	$tablaAppend .= '<td> <span class="' . $statusTipo2[$fila['statusA']] .'">'.  $fila['statusA'] .' </td>';
            	$tablaAppend .= '</tr>';
            }

            $tablaAppend .= '</tbody>';
			$tablaAppend .= '</table>';

		}
		catch(PDOException $e){
			$resultado .= "Error";
		}

    }
}

$resultados = array("results" => $resultado,
					"tablaAppend" => $tablaAppend);

echo json_encode($resultados);

?>