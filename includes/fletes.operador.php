<?php

$whereEconomico = "";
$whereFiltro = "";
$sql = "";
$mensaje = "";
$filtro = "";

if(isset($_POST) && !empty($_POST)){

		$statusTipo2 = array("Libre" => "label label-info",
                              "Ocupado" => "label label-warning",
                              "Indispuesto" => "label label-success",
                              "Fallido" => "label label-important"
                              );

	 $statusTipo = array("Activo" => "label label-info",
                          "Pendiente Facturacion" => "label label-warning",
                          "Completo" => "label label-success",
                          "Fallido" => "label label-important"
                        );

	$filtro = $_POST['filtro'];
	$economico = $_POST['economico'];
	$numero = $_POST['numero'];
	$action = $_POST['action'];

	$whereEconomico = "";
	$whereFiltro = "";

	switch ($action){
		case "general":
		$mensaje = date("Y",strtotime("-1 year"));

			if( strcmp($filtro, 'Todos') == 0  ){
				}
			else if(strcmp($filtro,  'Ultima Semana') == 0){
					$whereFiltro .= 'and Flete.Fecha > '. strtotime('last week');			
				}
			else if(strcmp($filtro, 'Ultimo mes') ==0){
					$whereFiltro .= 'and Flete.Fecha > '. date("Y-m-1", strtotime("-1 month"));
				}
			else if(strcmp($filtro, 'Ultimo año') ==0){
					$whereFiltro .= 'and Flete.Fecha > '. date("Y");
				}

			break;

		case "rango" :
		$mensaje .= "Entro a la seccion de rango";

			for ($i=0; $i < count($filtro) ; $i++) { 
				if($i <3){
					$fecha1 .= $filtro[$i] . '-';
				}
				else{
					$fecha2 .= $filtro[$i] . '-';
				}
			}
			$fecha1 = substr($fecha1, 0,-1);
			$fecha2 = substr($fecha2, 0,-1); 

		$whereFiltro .= 'and Flete.Fecha BETWEEN '. $fecha1.' and ' . $fecha2;
			break;
	}


	if( strcmp($economico, 'Todos') != 0){
		$whereEconomico .= 'and Flete.Economico = '. $economico;
	}
	
		$resulTable .= '<table class="table-condensed">
				    <thead>
				      <tr>
				        <th>#</th>
				        <th>Operador</th>
				        <th>Economico</th>
				        <th>Cliente</th>
				        <th>Agencia</th>
				        <th>Trafico</th>
				        <th>Tipo Viaje</th>
				        <th>Status</th>
				        <th> </th>
				        </tr></thead>
				        <tbody>';

	$PDOmysql = new PDO('mysql:host=www.timsalzc.com;dbname=timsalzc_ControlTimsa;charset=utf8', 'timsalzc_Raul', 'f203e21387');

	$sql = 'select distinct Flete.idFlete idFlete, Operador.Nombre nombre,
         Operador.ApellidoP apellidop, Operador.ApellidoM apellidom, Economico.Economico economico, Economico.Placas placas, 
         Cliente.Nombre cliente, ClienteDireccion.Localidad sucursal,Agencia.nombre agencia, CuotaDetalle.Trafico trafico,
         CuotaDetalle.TipoViaje TipoViaje,Flete.Fecha Fecha,Flete.statusA statusA 
         from 
         Cuota,Socio,Flete, Operador, Economico, Cliente, CuotaDetalle, ClienteDireccion, Agencia,VehiculoDetalle, Cuota_Flete
         where
         Operador.Eco = VehiculoDetalle.Operador and Economico.Economico = VehiculoDetalle.Economico and Socio.idSocio = VehiculoDetalle.Socio
         and Flete.Operador = VehiculoDetalle.Operador and Flete.Economico = VehiculoDetalle.Economico and Flete.Socio = VehiculoDetalle.Socio
         and Flete.Agencia_idAgente = Agencia.idAgente
         and Flete.idFlete = Cuota_Flete.NumFlete and Cuota_Flete.Cliente = Cliente.idCliente and Cuota_Flete.TipoCuota = CuotaDetalle.numero and
          Cuota_Flete.Cuota = CuotaDetalle.Cuota_idCuota and CuotaDetalle.Cuota_idCuota = Cuota.idCuota and Cuota.idCuota = ClienteDireccion.Cuota_idCuota 
          and ClienteDireccion.Cliente_idCliente = Cliente.idCliente and Flete.Operador = :socio
            '.$whereEconomico . '    ' . $whereFiltro .'
          ORDER BY idFlete ASC';

    $stmt = $PDOmysql->prepare($sql);
	$stmt->bindParam(':socio', $numero);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$resulTableResult = "";

	foreach ($rows as $fila){ 
        $resulTableResult.='
            <tr>
                <td>'. $fila['idFlete'].' </td>
                <td>'. $fila['nombre']. $fila['apellidop']. $fila['apellidom'].' </td>
                <td>'. $fila['economico']. ' </td>
                <td>'. $fila['cliente']  . ' </td>  
                <td>'. $fila['agencia']  . '  </td> 
                <td>'. $fila['trafico']  . '  </td>
                <td>'. $fila['TipoViaje'].'  </td>
                <td> <span class="'.$statusTipo[$fila['statusA']].'">'.$fila['statusA'] .' </span>  </td>
                <td> <button class="demo btn btn-success btn-mini" data-toggle="modal" href="#responsive">Detalles</button> <td>
            </tr>';
     }

   if($resulTableResult != ""){
	$result.= $resulTable;
	$result.= $resulTableResult;
	$result .= '</tbody> </table>';
	}
	else{
		$result.= "<h4><i>Este Operador no posee fletes Registrados con estas caracteristicas</i></h4>";
	}

	$result.= '<button class="btn btn-primary btn-large" id="EditarOperador"> Editar </button>';

}

$resultados = array("results" => $result,
					"mensaje" => $sql
					 );

echo json_encode($resultados);

?>