<?php

require_once("../includes/generic.connection.php");

class Dia{
	var $anio;
	var $dia;

	var $contenido;

	function Dia(){
	}

	function getRequest(){
		$PDOmysql = consulta();
		$rows = "";

		try{
			$sql = 'SELECT distinct 
					Flete.idFlete idFlete, Operador.Nombre nombre,
					Operador.ApellidoP apellidop, Operador.ApellidoM apellidom, Economico.Economico economico, Economico.Placas placas, 
					Cliente.Nombre cliente, ClienteDireccion.NombreSucursal sucursal,Agencia.nombre agencia,CuotaDetalle.Trafico trafico,
					CuotaDetalle.TipoViaje TipoViaje,Flete.Fecha Fecha,Flete.statusA statusA 

					FROM Flete,Cuota,Socio, Operador, Economico, Cliente, CuotaDetalle, ClienteDireccion, Agencia,VehiculoDetalle, Cuota_Flete
					WHERE
					Operador.Eco = VehiculoDetalle.Operador 
					and Economico.Economico = VehiculoDetalle.Economico 
					and Socio.idSocio = VehiculoDetalle.Socio
	           		and Flete.Operador = VehiculoDetalle.Operador 
	           		and Flete.Economico = VehiculoDetalle.Economico 
	           		and Flete.Socio = VehiculoDetalle.Socio
	           		and Flete.Agencia_idAgente = Agencia.idAgente
	           		and Flete.idFlete = Cuota_Flete.NumFlete 
	           		and Cuota_Flete.Sucursal = ClienteDireccion.Sucursal 
	           		and Cuota_Flete.TipoCuota = CuotaDetalle.numero 
	            	and Cuota_Flete.Cuota = CuotaDetalle.Cuota_idCuota 
	            	and CuotaDetalle.Cuota_idCuota = Cuota.idCuota 
	            	and Cuota.idCuota = ClienteDireccion.Cuota_idCuota 
	            	and ClienteDireccion.Cliente_idCliente = Cliente.idCliente 
	            	and
					DAYOFYEAR(Flete.Fecha) = :dia
					and
					YEAR(Flete.Fecha) = :anio
					ORDER BY idFlete';

			$stmt = $PDOmysql->prepare($sql);
			 $stmt->bindParam(':dia', $this->dia);
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
		$date = $this->getDateFromDay($this->dia, $this->anio);

		$this->contenido .='<div class="accordion-heading">
						      <a class="accordion-toggle" data-toggle="collapse" href="#dia'.$this->dia .'">
						         	'.$date->format('j F Y') .'
						      </a>
						    </div>';

		$this->contenido .=	 '<div id="dia'. $this->dia .'" class="accordion-body collapse">
						    		<div class="accordion-inner">';

		$this->contenido .= '<table class="table table-hover">
			 							<thead>
			 								<tr>
			 								    <th>#</th>
			 								    <th>Operador</th>
			 								    <th>Economico</th>
			 								    <th>Placas </th>
			 								    <th>Cliente</th>
			 								    <th>Sucursal</th>
			 								    <th>Agencia</th>
			 								    <th>Trafico</th>
			 								    <th>Tipo Viaje</th>
			 								    <th>Status</th>
			 								    <th>Hora</th>
			 								    <th> </th>
			 								</tr>
			 							</thead>
			 						    <tbody>';

		foreach($rows as $fila) {
			 
			$this->contenido .= '<tr>
					                <td>'. $fila['idFlete'].' </td>
					                <td>'. $fila['nombre']. $fila['apellidop']. $fila['apellidom'].' </td>
					                <td>'. $fila['economico']. ' </td>
					                <td> '. $fila['placas'].' </td>
					                <td>'. $fila['cliente']  . ' </td>  
					                <td>'. $fila['sucursal'] . '  </td> 
					                <td>'. $fila['agencia']  . '  </td> 
					                <td>'. $fila['trafico']  . '  </td>
					                <td>'. $fila['TipoViaje'].'  </td>
					                <td> <span class="'.$statusTipo[$fila['statusA']].'">'.$fila['statusA'] .'</span> </td>
					                <td>'. $fila['Fecha']    .'  </td>
					                <td> <button class="demo btn btn-success btn-mini" data-toggle="modal" href="#responsive">Detalles</button> <td>
					            </tr>';
				                       
			
		}

		$this->contenido .= '</tbody>
			 				 </table>';

		$this->contenido.= ' <br>';

		$this->contenido.= '</div>';
		$this->contenido.= '</div>';

		return $this->contenido;
	}

	function getDateFromDay($dayOfYear, $year) {
		  $date = DateTime::createFromFormat('z Y', strval($dayOfYear-1) . ' ' . strval($year));
		  return $date;
	}


}

?>