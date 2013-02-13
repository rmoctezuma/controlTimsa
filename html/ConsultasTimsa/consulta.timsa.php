<?php

// Constantes conexión con la base de datos


// Variable que indica el status de la conexión a la base de datos
$errorDbConexion = false;


// Función para extraer el listado de usurios
function consultaUsers($linkDB){

        $conexion = mysql_connect("localhost","TIMSA","TIMSA");

        if (!$conexion) {
          echo "Unable to connect to DB: " . mysql_error();
          exit;
        }

        if (!mysql_select_db("timsa")) {
            echo "Unable to select mydbname: " . mysql_error();
            exit;
        }

        $sql = 'select distinct Flete.idFlete idFlete, Operador.Nombre nombre,
         Operador.ApellidoP apellidop, Operador.ApellidoM apellidom, Vehiculo.Economico economico, Vehiculo.Placas placas, 
         Cliente.Nombre cliente, ClienteDireccion.Localidad sucursal,Agencia.nombre agencia, Flete.Trafico trafico,
         Flete.TipoViaje TipoViaje,Flete.Fecha Fecha,Flete.statusA statusA from Flete,Operador,Vehiculo,Agencia,Cliente,ClienteDireccion,Cuota
          where Flete.Operador_Eco = Operador.Eco and Flete.Vehiculo_idVehiculo = Vehiculo.Economico and Flete.Cliente_idCliente = Cliente.idCliente 
          and Flete.Agencia_idAgente = Agencia.idAgente and ClienteDireccion.Cliente_idCLiente = Flete.Cliente_idCliente and  ClienteDireccion.Cuota_idCuota = Flete.cuota;';
        $query = mysql_query($sql);

        if (!$query) {
           echo "Could not successfully run query ($sql) from DB: " . mysql_error();
          exit;
        }
        while ($fila = mysql_fetch_assoc($query)){
        	echo $fila['sucursal'];
          echo "<tr>";
          printf("<td> %s </td>",$fila['idFlete']);
          printf("<td> %s %s %s </td>",$fila['nombre'],$fila['apellidop'],$fila['apellidom']);
          printf("<td> %s %s </td>",$fila['economico'],$fila['placas']);
          printf("<td> %s </td>",$fila['cliente']);
          printf("<td> %s </td>",$fila['sucursal']);
          printf("<td> %s </td>",$fila['agencia']);
          printf("<td> %s </td>",$fila['trafico']);
          printf("<td> %s </td>",$fila['TipoViaje']);
          printf("<td> %s </td>",$fila['statusA']);
          printf("<td> %s </td>",$fila['Fecha']);
          echo "<td> <button class ='btn btn-success'> Editar </button> </td>";
          echo "</tr>";
        }
        mysql_free_result($query);
            echo "</tbody>";

      echo "</table>";



	$statusTipo = array("Activo" => "btn-success",
						"Suspendido" => "btn-warning");

	$salida = '';

	$consulta = $linkDB -> query("SELECT id_user,usr_nombre,usr_puesto,usr_nick,usr_status
								  FROM tbl_usuarios ORDER BY usr_nombre ASC");

	if($consulta -> num_rows != 0){
		
		// convertimos el objeto
		while($listadoOK = $consulta -> fetch_assoc())
		{
			$salida .= '
				<tr>
					<td>'.$listadoOK['usr_nombre'].'</td>
					<td>'.$listadoOK['usr_puesto'].'</td>
					<td>'.$listadoOK['usr_nick'].'</td>
					<td class="centerTXT"><span class="btn btn-mini '.$statusTipo[$listadoOK['usr_status']].'">'.$listadoOK['usr_status'].'</span></td>
					<td class="centerTXT"><a class="btn btn-mini" href="'.$listadoOK['id_user'].'">Editar</a></td>
				<tr>
			';
		}

	}
	else{
		$salida = '
			<tr id="sinDatos">
				<td colspan="5" class="centerTXT">NO HAY REGISTROS EN LA BASE DE DATOS</td>
	   		</tr>
		';
	}

	return $salida;
}

// Verificar constantes para conexión al servidor

	// Conexión con la base de datos	
	$mysqli = new PDO('mysql:host=localhost;dbname=timsalzc_ControlTimsa;charset=UTF-8', 'timsalzc_Raul', 'f203e21387');
?>