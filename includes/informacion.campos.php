<?php

require_once("Objetos/Lista.Operadores.php");
require_once("Objetos/Lista.Economicos.php");
require_once("Objetos/ListaClientes.php");
require_once("Objetos/ListaSucursales.php");
require_once("Objetos/Flete.php");

$contenido = "";
$tipoDeViaje = "";

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

		case 'Viaje':

		$contenido .= '<div class="container">';

			$contenido .= '<form id="contenedores">';
			$contenido .= '<input type="hidden" value="Contenedor" name="tipo">';
			$contenido .= '<input type="hidden" value="'. $_POST['flete'] .'" name="flete">';

			$flete = new Flete;
			$flete->getFleteFromID( $_POST['flete'] );
			$cuota = $flete->get_CuotaViaje();

			$trafico = $cuota->get_trafico();
			$tipoDeViaje = $cuota->get_tipoViaje();

			$contenedores = $flete->get_listaContenedores()->get_contenedores();

/*
			if(count($contenedores) > 1){
			     $tipoDeViaje = "Full";
			}
			else{
			    $tipoDeViaje = "Sencillo";  
			}
*/
			$contenido .= '<h2>Tipo de Viaje </h2>';
			$contenido .= '<table><tr>';
			$contenido .= '<td><input name="tipoTrafico" type="text" value="'. $trafico .'" readonly></td><td></td>';
			$contenido .= '</tr></table>';
			$contenido .= '<div id="opcionesViaje">';
			$contenido .= '<label style="display:inline"> &nbspSencillo  </label><input required  type="radio" name="tipoViaje" value="Sencillo" >';
			$contenido .= '<label style="display:inline"> &nbsp Full  </label> <input  required type="radio" name="tipoViaje" value="Full" >';
			$contenido .= '</div>';
			$contenido .= '<br><br>';

			$contenido .= '<div id="nuevosContenedores" class="container">';
			for ($i=0; $i < 2; $i++){
			      $contenido .= ' <div class="span3" id="contenedor'.($i+1).'">

			                        <label>Contenedor</label>  <input maxlength="15"  required name="contenedor'.($i+1).'" type="text" value="'.$contenedores[$i].'">
			                        <label>Tamaño </label> 
			                        <select name="tamaño'.($i+1).'" >';

			                        $valores = array("40HC", "40DC", "20HC", "20DC");
			                        if(is_object($contenedores[$i])) {
			                              $tipoContenedor = $contenedores[$i]->get_tipo();
			                              $pieces = explode(" ", $tipoContenedor);
			                              $tipoContenedor = $pieces[1];

			                              $workorder = $contenedores[$i]->get_workorder();
			                              $booking = $contenedores[$i]->get_booking();
			                            }
			                            else{
			                              $tipoContenedor = "40HC";
			                              $workorder = "";
			                              $booking = "";
			                            }

			                        for ($e=0; $e < count($valores); $e++) {
			                              if($tipoContenedor == $valores[$e]){ 
			                                    $contenido.= '<option value="'.$valores[$e].'" selected> '.$valores[$e].'</option>';
			                              }
			                              else{
			                                    $contenido.= '<option value="'.$valores[$e].'"> '.$valores[$e].'</option>';  
			                              }
			                        }
			                               
			       $contenido .= '</select>
			                        <label>WorkOrder</label><input  required name="workorder'.($i+1).'" value="'. $workorder .'" type="text">
			                        <label>Booking</label>   <input required name="booking'.($i+1).'" value="'. $booking .'" type="text">                                            
			                  </div>';
			}
			

			$contenido .= '</div>
							<input type="submit" id="salvarContenedores"  class="btn btn-primary"  value="salvar">
							<input type="reset" id="cancelarContenedores" class="btn" value="cancelar"> ';

			$contenido .= '</form>';

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

$resultados  = array('contenido' => $contenido,
					 'viaje' => $tipoDeViaje);

echo json_encode($resultados);

?>