<?php

$contenido = "";
$contador = 0;
$contenidoContenedor = "<td> Contenedor </td>";
$contenidoWorkOrder = "<td> WorkOrder </td>";
$contenidoBooking = "<td> Booking </td>";
$contenidoSellos = '<tr id="Sello1">';
$contenidoSellos.= '<td>Sello 1 </td>';
$contenidoTipo .= '<td> Tipo Contenedor </td>';

if(isset($_POST) && !empty($_POST)){
	if( $_POST['tipoViaje'] == "Full"){
		$contador = 2;
	}
	else{
		$contador = 1;
	}

	while($contador > 0){
		$ID = "acordeon" + $contador;
		$contenidoContenedor .= "<td>";
		$contenidoWorkOrder .= "<td>";
		$contenidoBooking .= "<td>";
		$contador -= 1;

		$contenido .='<div class="accordion-group">';
	    $contenido .= '<div class="accordion-heading">
		                  <a class="accordion-toggle" data-toggle="collapse" data-parent="acordeon" href="#'.$ID.'">
		                    Contenedor 
		                  </a>
		                </div>
		                <div id="'. $ID .'" class="accordion-body collapse">
	                  <div class="accordion-inner">';

		$contenido.='<div>';
		$contenido.='<div span4>';
		$contenido.='<h4>Datos Principales </h4>';
		$contenido.='<input type="text" maxlength="15" name="contenedor'.($contador +1).'" class="contenedorInput" placeholder="Nombre Contenedor">';
		$contenido.='<input type="text" name="workorder'.($contador +1).'" class="contenedorInput" placeholder="WorkOrder">';
		$contenido.='</div>';
		$contenido.='<div span4>';
		$contenido.='<input type="text" name="booking'.($contador +1).'" class="contenedorInput" placeholder="Booking">';
		$contenido.='<select class="tipoContenedor" title="tipoContenedor'.($contador +1).'">
					  <option>40HC</option>
					  <option>40DC</option>
					  <option>20HC</option>
					  <option>20DC</option>
					</select>';
		$contenido.='</div>';

		$contenido.= '<h4>Sellos</h4>';
		$contenido.= '<select class="sellos" id="sellosPanes'.($contador +1).'" title="sellosPane'.($contador +1).'">
					  <option>1</option>
					  <option>2</option>
					  <option>3</option>
					</select>';



		$contenido .= '<div id="sellosPane'.($contador +1).'">';
		$contenido.= '<input type="text" name="sello'.($contador + 1).'" class="selloInput" placeholder="Sello 1">';
		$contenido .= '</div>';

		$contenido .= '</div>';
		$contenido .= '</div>';
		$contenido .= '</div>';
		$contenido .= '</div>';

		$contenidoContenedor.= '<span id="contenedor'.($contador +1).'" class="label label-inverse span"> Sin especificar </span>';
		$contenidoContenedor .= '</td>';
		$contenidoWorkOrder .= '<span id="workorder'.($contador +1).'" class="label label-inverse span"> Sin especificar </span>';
		$contenidoWorkOrder .= '</td>';
		$contenidoBooking .= '<span id="booking'.($contador +1).'" class="label label-inverse span"> Sin especificar </span>';
		$contenidoBooking.= '</td>';

		$contenidoSellos.='<td> <span id="sello'.($contador +1).'" class="label label-inverse span"> Sin especificar </span> </td> ';

		$contenidoTipo.='<td> <span id="tipoContenedor'.($contador +1).'" class="label label-inverse span"> 40HC </span> </td>';

	}

	$contenidoSellos.='</tr>';

}

$salidaJson =  array(
						"contenido" => $contenido,
						"contenidoContenedor" => $contenidoContenedor,
						"contenidoWorkOrder" => $contenidoWorkOrder,
						"contenidoBooking" => $contenidoBooking,
						"contenidoSellos" => $contenidoSellos,
						"contenidoTipo" => $contenidoTipo
				);

echo json_encode($salidaJson);

?>