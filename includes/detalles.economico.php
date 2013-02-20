<?php
include('../includes/generic.connection.php');

$result = "";

if(isset($_POST) && !empty($_POST)){
	$numero = $_POST['economico'];
	$placas = $_POST['placas'];

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

	$result .= '<h1 title="'.$numero.'" id="NombreOperador"><img src="../img/logo.png" class="img-rounded"> Economico  '. $numero .' <button class="btn btn-primary btn-large" data-toggle="button" id="EditarOperador"> Editar </button></h1>';
	$result .= '<h5> Numero de Placas '.$placas.'</h5>';
	$result .= '<hr>';

	$result .= '<div id="appendOperador">';
	$result .= '<label> Agregar Operador al economico </label> <br>';
	$result .= '<select name="operador">';
    $sql = 'select Operador.Nombre nombre, Operador.ApellidoP apellido, Operador.ApellidoM apellidom, Operador.Eco economico
          from  Operador where statusA <> "deprecated" Order by Nombre asc';

    $PDOmysql = consulta();

    $stmt = $PDOmysql->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $fila) {
        $result .= '<option value="'. $fila['economico'].'">'.$fila['nombre']. ' '. $fila['apellido'] .' '. $fila['apellidom'] .  ' </option><br>';
     }
     $result .= '</select>';
     $result .=  '<span> <button id="append" class="btn btn-mini btn-primary"> agregar </button></span>';
     $result .= '<br>';
     $result .= '<hr>';
     $result .= '</div>';
     $result .= '<br>'; 

	$result .= '<h4> Operadores que han conducido este economico </h4>';

	$sql = 'select Operador.Eco Economico, Operador.Nombre, Operador.ApellidoP, Operador.ApellidoM, Operador.statusA
	from Operador,VehiculoDetalle
	where
	VehiculoDetalle.Operador = Operador.Eco
	and
	VehiculoDetalle.Economico = :economico ';

	 $stmt = $PDOmysql->prepare($sql);
	 $stmt->bindParam(':economico', $numero);
	 $stmt->execute();
	 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	 $resultEconomicos .= '<table class="table table-condensed span5">';
	 $resultEconomicos .= '<thead>';
	 $resultEconomicos .= '<tr>  <th>Operador </th> <th>Nombre </th> <th> Status </th>  </tr>';
	 $resultEconomicos .= '</thead>';
	 $resultEconomicos .= '<tbody>';

	 $resultEconomicosResult = "";
	 $optionEconomicos = "";

	 foreach ($rows as $row){
	 	$optionEconomicos.= '<option>'. $row['Economico'] .' </option>';

	 	$resultEconomicosResult .= '<tr> ';   
		$resultEconomicosResult.=  '<td>'. $row['Economico'] .' </td>  <td> '. $row['Nombre'] . ' '.$row['ApellidoP'].' '. $row['ApellidoM'].'</td><td> <span class="' . $statusTipo2[$row['statusA']] .'">'. $row['statusA']  .'  </span> </td>';
	    $resultEconomicosResult .= '</tr>';
	}

	if($resultEconomicosResult != ""){
		$result .= $resultEconomicos;
		$result .= $resultEconomicosResult;
		$result .= '</tbody>';
	    $result .= '</table><br>';
	}
	else{
		$result .= '<h4><i>Este Socio no posee ningun Economico</i></h4>';
	}

	 $result .= '<br><h3><br> Fletes de Este Socio </h3>';

	 $sql = 'select distinct Flete.idFlete idFlete, Operador.Nombre nombre,
         Operador.ApellidoP apellidop, Operador.ApellidoM apellidom, Economico.Economico economico, Economico.Placas placas, 
         Cliente.Nombre cliente, ClienteDireccion.Localidad sucursal,Agencia.nombre agencia, CuotaDetalle.Trafico trafico,
         CuotaDetalle.TipoViaje TipoViaje,Flete.Fecha Fecha,Flete.statusA statusA 
         from 
         Cuota,Socio,Flete, Operador, Economico, Cliente, CuotaDetalle, ClienteDireccion, Agencia,VehiculoDetalle, Cuota_Flete
         where
         Operador.Eco = VehiculoDetalle.Operador and Economico.Economico = VehiculoDetalle.Economico and Socio.idSocio = VehiculoDetalle.Socio
         and Flete.Operador = VehiculoDetalle.Operador and Flete.Economico = :economico and Flete.Socio = VehiculoDetalle.Socio
         and Flete.Agencia_idAgente = Agencia.idAgente
         and Flete.idFlete = Cuota_Flete.NumFlete and Cuota_Flete.Cliente = Cliente.idCliente and Cuota_Flete.TipoCuota = CuotaDetalle.numero and
          Cuota_Flete.Cuota = CuotaDetalle.Cuota_idCuota and CuotaDetalle.Cuota_idCuota = Cuota.idCuota and Cuota.idCuota = ClienteDireccion.Cuota_idCuota 
          and ClienteDireccion.Cliente_idCliente = Cliente.idCliente and Flete.Socio = VehiculoDetalle.Socio
          ORDER BY idFlete ASC';

     $stmt = $PDOmysql->prepare($sql);
	 $stmt->bindParam(':economico', $numero);
	 $stmt->execute();
	 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	 $resulTable .= "";
	 $resulTable .= '<div class="span7">';

	 $resulTable .= '<span><label class="radio inline">
                        <input type="radio" name="optionsRadios" value="1">General                                         
                    </label>';

    $resulTable .= '<label class="radio inline">
                        <input type="radio" name="optionsRadios" value="2">
                        Por Rango de Tiempo                                    
                    </label></span>';


	 $resulTable .= '<select id="Filtro">
	 					<option> Todos </option>
	 					 <option> Ultima Semana </option>
	 					 <option> Ultimo mes </option>
	 					 <option> Ultimo año </option> 
	 			    </select> <br><br>';

	 $resulTable .= '<select name="dia" class="Fechas">'. consultaDia().'</select>';

	$resulTable .='<select name="mes" class="Fechas">'. consultaMes(). '</select>';
	$resulTable .='<select name="anio" class="Fechas">'. consultaAnio(). '</select> <br>';

    $resulTable .= '<select name="dia2" class="Fechas">'. consultaDia().'</select>';

	$resulTable .='<select name="mes2" class="Fechas">'. consultaMes(). '</select>';
	$resulTable .='<select name="anio2" class="Fechas">'. consultaAnio(). '</select>';

	$resulTable .= '</div>';
	$resulTable .= '<div>';

	 $resulTable .= '<label>Operador ';

	 $resulTable .= '<select id="FiltroEconomico">
	 					<option>Todos </option>
	 					'.$optionEconomicos.'
	 			    </select> </label><br><br>';

     $resulTable .= '<div id="table">';	
	 $resulTable .= '<table class=" table table-condensed">
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

	$resulTable .= '<div>';

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
                <td>'. $fila['Fecha']    .'  </td>
                <td> <button class="demo btn btn-success btn-mini" data-toggle="modal" href="#responsive">Detalles</button> <td>
            </tr>';
     }

if($resulTableResult != ""){
	$result.= $resulTable;
	$result.= $resulTableResult;
	$result .= '</tbody> </table>';
	$result .= '<div>';
}
else{
		$result.= "<h4><i>Este Economico no posee fletes Registrados</i></h4>";
}
 	$result .= '<hr>';

}

$resultados = array("results" => $result);

echo json_encode($resultados);



function consultaDia(){
	$fecha = "";
	for ($i=1; $i<=31; $i++) {
		if ($i == date('j'))
			$fecha.='<option value="'.$i.'" selected>'.$i.'</option>';
		 else
			$fecha.= '<option value="'.$i.'">'.$i.'</option>';
	}

	return $fecha;
}

function consultaMes(){
	$fecha = "";
        for ($i=1; $i<=12; $i++) {
            if ($i == date('m'))
                $fecha.= '<option value="'.$i.'" selected>'.$i.'</option>';
            else
                $fecha.= '<option value="'.$i.'">'.$i.'</option>';
        }
       return $fecha; 
   
}

function consultaAnio(){
	$fecha = "";
	 for($i=date('o'); $i>=1910; $i--){
            if ($i == date('o'))
                $fecha.= '<option value="'.$i.'" selected>'.$i.'</option>';
            else
               $fecha.='<option value="'.$i.'">'.$i.'</option>';
        }
        return $fecha;
}


?>