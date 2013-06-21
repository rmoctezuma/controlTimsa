<?php

require_once("Objetos/Lista.Operadores.php");
require_once("Objetos/Lista.Economicos.php");
require_once("Objetos/ListaClientes.php");
require_once("Objetos/ListaSucursales.php");
require_once("Objetos/Flete.php");

$contenido = "";

if(isset($_POST) && !empty($_POST)){
	switch ($_POST['tipo']) {
		case 'Operador':

			$economico = "";

			if(isset($_POST['economico']) && !empty($_POST['economico'])){
				$economico = $_POST['economico'];

				$objetoEconomico = new Economico;
				$objetoEconomico->set_id($economico);


				$contenido .= '<div>
									<input id="nuevoSocio" type="hidden" value="'. $objetoEconomico->get_Socio() .'" >
							   </div>';
			}
			else{

				$flete = new Flete;
				$flete->getFleteFromID($_POST['flete']);

				$economico = $flete->get_Economico()->get_id();
			}
			
			$listaDeOperadores = new ListaOperadores;
			$listaDeOperadores->createListaOperadoresWithEconomicoAndFreeStatus($economico);

			if(! $listaDeOperadores->hasNext() ){
				$contenido .= ' <div> 
									<table>
										<tr>
											<td>
											No existen Operadores libres para este economico
											Selecciona otro.
											</td>
											<td><button class="btn cancelar"> Cancelar </button></td>
										</tr>
									</table>
								</div>';

			}
			else{

			$contenido .= ' <div>
							<table>
							<tr>
							<td> <label>Selecciona Operador<label> </td>
							<td> 
							<select>';

			while ( $listaDeOperadores->hasNext() ) {

				$operador = $listaDeOperadores->getOperador();

				$contenido .= '<option value="'. $operador->get_id() .'">
									'. $operador->get_nombre() . ' ' . $operador->get_apellidop() . 
									' ' . $operador->get_apellidom()
							.' </option>';

			}

			$contenido .= '</select>
						   </td>
						   </tr>';

			$contenido .= '<tr><td> <button class="btn btn-primary update"> Cambiar </button>';
			$contenido .= '<button class="btn cancelar"> Cancelar </button></td></tr>
						   </div>';
			}

			break;
		
		case 'Economico':
			
			$lista = new ListaEconomicos;

			$contenido .= ' <div>
							<table>
							<tr>
							<td> <label> Selecciona Economico </label>
							<td>
							<select id="selectEconomicos">';

			while ( $lista->hasNext() ) {

				$elemento = $lista->getElement();

				$contenido .= '<option value="'. $elemento->get_id() .'">
									'. $elemento->get_id() . ' ' . $elemento->get_placas()
							.' </option>';

			}

			$contenido .= '</select></td></tr></table>';

			break;

		case 'Cliente':
			
			$lista = new ListaClientes;

			$contenido .= ' <div>
							<table>
							<tr>
							<td> <label> Selecciona Cliente </label> </td>
							<td>
							<select id="cambio_cliente">';

			while ( $lista->hasNext() ) {

				$elemento = $lista->getElement();

				$contenido .= '<option value="'. $elemento->get_id() .'">
									'. $elemento->get_nombre()
							.' </option>';

			}

			$contenido .= '</select>
							</td>
							</tr>
							</table>';


			$contenido.='</div>';
			break;

		case 'Sucursal':
			$sucursales = new ListaSucursales;
			$sucursales->getSucursalesFromCliente($_POST['cliente']);



			if ($sucursales->hasNext()) {

				$contenido .= '<div>
								<table>
									<tr>
									<td> <label> Selecciona Sucursal </label> </td>
									<td>
									<select id="sucursal">';

				while ($sucursales->hasNext() ) {
					$elemento = $sucursales->getElement();

					$contenido .= '<option value="'. $elemento->getID() .'">
									'. $elemento->get_nombreSucursal() .'
								  </option>';
				}

				$contenido .= '</select></td>';

				if($_POST['trafico'] !== 'Reutilizado'){
					$flete = new Flete;
					$flete->getFleteFromID($_POST['flete']);

					if(! $flete->get_FleteHijo() ){

						$contenido .= '<tr>
										<td> <label> Selecciona Tipo de Viaje </label> </td>
										<td>
										<select id="viaje">
											<option value ="Importacion"> Importacion </option>
											<option value ="Exportacion"> Exportacion </option>
										</select><td>
										</tr>';
					}
					
				}

				

				$contenido .= '<tr><td><button class="btn btn-primary update"> Cambiar </button>';
				$contenido .= '<button class="btn cancelar"> Cancelar </button></td></tr>';

				$contenido .= '</table>
								</div>';
				
			}
			else{
				$contenido .= "No existen Sucursales para este cliente";
				$contenido .= '<div>
							<table><tr><td><button class="btn cancelar"> Cancelar </button></td></tr></table></div>';
			}

			break;
	}
}

$resultados  = array('contenido' => $contenido);

echo json_encode($resultados);

?>