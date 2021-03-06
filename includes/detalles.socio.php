<?php

include('../includes/generic.connection.php');
require_once('../includes/Objetos/Socio.php');

$result = "";

if(isset($_POST) && !empty($_POST)){
	$numero = $_POST['numero'];
	$nombre = $_POST['nombre'];

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

	$result .= '<br>';
	$result .= '<br>';
	$result .= '<br>';

	$socio = new Socio;
	$socio->createSocioFromID($numero);

	$result .= '<div class="container-fluid">';
	$result .= '<img class="span3" src="'. $socio->get_imagen() .'">
				<div class="span5">
					<h2> '. $socio->get_Nombre() .' </h2>
					<button class="btn btn-info editarsocio" value="'.$numero.'" >Editar</button>
					<h5>NC<big> '. $socio->get_idSocio() .'</big></h5>
				</div>';

	$result .= '<div class="span5">
				<dl class="dl-horizontal">
					<dt> Telefono </dt> <dd><input type="text" readonly value='. $socio->get_telefono() .'" </dd>
				</dl>
				</div>';

	$result .= '</div>';

/*
	$result .= '<h1 title="'.$numero.'" id="Nombresocio">'. $nombre .' <button class="btn btn-primary btn-large" id="Editarsocio"> Editar </button></h1>';
	$result .= '<hr>';
*/
	$result .= '<h3> Economicos pertenecientes al Socio </h3>';

	$PDOmysql = new PDO('mysql:host=www.timsalzc.com;dbname=timsalzc_ControlTimsa;charset=utf8', 'timsalzc_Raul', 'f203e21387');

	$sql = 'select distinct Economico.Economico, Economico.Placas,Economico.statusA 
	from Economico,VehiculoDetalle 
	where 
	VehiculoDetalle.Economico = Economico.Economico
	 and  
	 VehiculoDetalle.Socio = :socio ';

	 $stmt = $PDOmysql->prepare($sql);
	 $stmt->bindParam(':socio', $numero);
	 $stmt->execute();
	 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	 $resultEconomicos .= '<table class="table table-condensed">';
	 $resultEconomicos .= '<thead>';
	 $resultEconomicos .= '<tr>  <th>Economico </th> <th> Placas </th> <th> Status </th>  </tr>';
	 $resultEconomicos .= '</thead>';
	 $resultEconomicos .= '<tbody>';

	 $resultEconomicosResult = "";
	 $optionEconomicos = "";

	 foreach ($rows as $row){ 
	 	$optionEconomicos.= '<option>'. $row['Economico'] .' </option>';

	 	$resultEconomicosResult .= '<tr> ';   
		$resultEconomicosResult.=  ' <td>'. $row['Economico'] .' </td>  <td> '. $row['Placas'] .'</td><td> <span class="' . $statusTipo2[$row['statusA']] .'">'. $row['statusA']  .'  </span> </td>';
	    $resultEconomicosResult .= '</tr>';
	}

	if($resultEconomicosResult != ""){
		$result .= $resultEconomicos;
		$result .= $resultEconomicosResult;
		$result .= '</tbody>';
	    $result .= '</table>';
	}
	else{
		$result .= '<h4><i>Este Socio no posee ningun Economico</i></h4>';
	}
}

	/*

	 $result .= '<h3> Fletes de Este Socio </h3>';

	 $PDOmysql = new PDO('mysql:host=www.timsalzc.com;dbname=timsalzc_ControlTimsa;charset=utf8', 'timsalzc_Raul', 'f203e21387');

	 $sql = 'select distinct Flete.idFlete idFlete, socio.Nombre nombre,
         socio.ApellidoP apellidop, socio.ApellidoM apellidom, Economico.Economico economico, Economico.Placas placas, 
         Cliente.Nombre cliente, ClienteDireccion.Localidad sucursal,Agencia.nombre agencia, CuotaDetalle.Trafico trafico,
         CuotaDetalle.TipoViaje TipoViaje,Flete.Fecha Fecha,Flete.statusA statusA 
         from 
         Cuota,Socio,Flete, socio, Economico, Cliente, CuotaDetalle, ClienteDireccion, Agencia,VehiculoDetalle, Cuota_Flete
         where
         socio.Eco = VehiculoDetalle.socio and Economico.Economico = VehiculoDetalle.Economico and Socio.idSocio = VehiculoDetalle.Socio
         and Flete.socio = VehiculoDetalle.socio and Flete.Economico = VehiculoDetalle.Economico and Flete.Socio = VehiculoDetalle.Socio
         and Flete.Agencia_idAgente = Agencia.idAgente
         and Flete.idFlete = Cuota_Flete.NumFlete and Cuota_Flete.Sucursal = ClienteDireccion.Sucursal and Cuota_Flete.TipoCuota = CuotaDetalle.numero and
          Cuota_Flete.Cuota = CuotaDetalle.Cuota_idCuota and CuotaDetalle.Cuota_idCuota = Cuota.idCuota and Cuota.idCuota = ClienteDireccion.Cuota_idCuota 
          and ClienteDireccion.Cliente_idCliente = Cliente.idCliente and Flete.Socio = :socio
          ORDER BY idFlete ASC';

     $stmt = $PDOmysql->prepare($sql);
	 $stmt->bindParam(':socio', $numero);
	 $stmt->execute();
	 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	 $resulTable .= "";

	 $resulTable .= '<label class="radio inline">
                        <input type="radio" name="optionsRadios" value="1">
                        General                                    
                    </label>';

    $resulTable .= '<label class="radio inline">
                        <input type="radio" name="optionsRadios" value="2">
                        Por Rango de Tiempo                                    
                    </label>';


	 $resulTable .= '<select id="Filtro">
	 					<option> Todos </option>
	 					 <option> Ultima Semana </option>
	 					 <option> Ultimo mes </option>
	 					 <option> Ultimo año </option> 
	 			    </select> <br><br>';

	 

	 $resulTable .= '<select name="dia" class="Fechas">'. consultaDia().'</select>';

	$resulTable .='<select name="mes" class="Fechas">'. consultaMes(). '</select>';
	$resulTable .='<select name="anio" class="Fechas">'. consultaAnio(). '</select>';

    $resulTable .= '<select name="dia2" class="Fechas">'. consultaDia().'</select>';

	$resulTable .='<select name="mes2" class="Fechas">'. consultaMes(). '</select>';
	$resulTable .='<select name="anio2" class="Fechas">'. consultaAnio(). '</select>';

	 $resulTable .= '<label>Economico </label>';

	 $resulTable .= '<select id="FiltroEconomico">
	 					<option>Todos </option>
	 					'.$optionEconomicos.'
	 			    </select> <br><br>';

	 $resulTable .= '<div id="table" class="span8">';	
	 $resulTable .= '<table class="table table-condensed">
				    <thead>
				      <tr>
				        <th>#</th>
				        <th>socio</th>
				        <th>Economico</th>
				        <th>Cliente</th>
				        <th>Agencia</th>
				        <th>Trafico</th>
				        <th>Tipo Viaje</th>
				        <th>Status</th>
				        <th> </th>
				        </tr></thead>
				        <tbody>';

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
	$result .= '</div>';
}
else{
	$result.= "<h4><i>Este Socio no posee fletes Registrados</i></h4>";
}
 	$result .= '<hr>';
}
*/
$resultados = array("results" => $result);

echo json_encode($resultados);

/*

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

*/

?>