<?php

require_once("../includes/generic.connection.php");
require_once("Objetos/ListaClientes.php");
require_once("Objetos/ListaAgencia.php");
require_once("Objetos/Flete.php");

	$forma = ""; # Formulario para la creacion de los fletes reutilizados.

	if(isset($_POST) && !empty($_POST)){
		$idFlete = $_POST['flete'];
		$contenedores = $_POST['contenedores'];
            #Crea los espacios para el formulario, y los estiliza en forma de tabla.
            $forma .= '<form id="formaReutilizado" style="display: block;"  method="POST" action="../includes/FleteReutilizado.php">';
             $forma .='<h1><a id="newBack"><img src="http://control.timsalzc.com/Timsa/img/back-arrow.png"></a>  Reutilizar Flete</h1>';
            $forma .= '<div class="datosFleteReutilizado">';
            $forma .= '<table> <tbody>';
            $forma .= '<tr>
                        <!--<td><h3>Datos de Flete Anterior </h3></td>-->
                        </tr>';
            $forma .= '<tr>
                        <td><h4> Flete Raiz </h4></td>';
            $forma .= '<td><input readonly name="fletePadre" type="text" value="'.$idFlete.'"></td>
                      </tr>';
            #Crea una clase Flete, la cual se encarga de obtener todos los datos del flete anterios 
            #gracias al ID padre que tenemos de el.
            $FletePadre = new Flete;
            $FletePadre->getFleteFromID($idFlete);

            $operador = $FletePadre->get_Operador(); #Obtenemos el operador del flete.

            $forma.= '<tr>
                        <td><h4>Operador</h4></td>';
            $forma.= '<td><input readonly type="text" value="'. $operador->get_nombre().  $operador->get_apellidop(). $operador->get_apellidom().'"></td>
                     </tr>';
            $forma.= '<tr>
                        <td><h4> Economico </h4></td>';
            $forma.= '<td><input readonly type="text" value="'. $FletePadre->get_Economico()->get_id() .'"></td>
                        </tr>';

      	$forma .= '<tr>
                         <td><h4>Agencia</h4></td>';
      	$forma .=   '<td><select id="Agencia" name="Agencia">
                       ';

      	$agencias 		 = new ListaAgencia; #Listamos las agencias gracias a una clase.
      	$ListaAgencias   = $agencias->getAgencias();

      	for ($i=0; $i < count($ListaAgencias); $i++) { #Iteramos a traves de la cantidad de agencias para rellenas el select.
      		$agencia = $ListaAgencias[$i];
      		$forma .= '<option value= "'. $agencia->getAgencia() .'" >' . $agencia->getNombre() . '</option>';
      	}
      	$forma .= '      </select></td>
                        </tr>';


      	$forma .= '<tr>
                        <td><h4>Cliente</h4></td>';

      	$clientes 		 = new ListaClientes;
      	$ListaClientes   = $clientes->getLista();

      	$forma .= '<td> <select id="Cliente" name="Cliente">'; #Iteramos entre clientes. Rellenamos select

      	for ($i=0; $i < count($ListaClientes); $i++) {
      		$cliente = $ListaClientes[$i];
      		$forma .= '<option value= "'. $cliente->getID() .'" >' . $cliente->getNombre() . '</option>';
      	}

      	$forma .= '</select></td>
                        </tr>';
            
            $forma .= '</tbody></table>';
            $forma.='</div>';

                  #Se crean los formularios para los contenedores.
                  #Se crean las opciones para seleccionar tipos de viaje.
                  
                  $contenedores;
                  if($contenedores == "true"){
                        $contenedores = $FletePadre->get_listaContenedores()->get_contenedores();
                  }
                  else{
                      $contenedores = array("","");  
                  }

                  $forma .= '<h4>Tipo de Viaje </h4>';
                  $forma .= '<div id="opcionesViaje">';
                  $forma .= '<label style="display:inline"> &nbspSencillo  </label><input type="radio" name="tipoViaje" value="Sencillo" >  ';
                  $forma .= '<label style="display:inline"> &nbsp Full  </label> <input type="radio" name="tipoViaje" value="Full" > ';
                  $forma .= '</div>';
                  $forma .= '<br><br>';

                  #Se itera para obtener la cantidad de contenedores.
                  $forma .= '<div id="nuevosContenedores">';
                  for ($i=0; $i < 2; $i++) {                      
                        $forma .= ' <div class="span3" id="contenedor'.($i+1).'">
                                          <label>Contenedor</label>  <input  class="required" name="contenedor'.($i+1).'" type="text" value="'.$contenedores[$i].'">
                                          <label>WorkOrder</label><input class="required" name="workorder'.($i+1).'" type="text">
                                          <label>Booking</label>   <input class="required" name="booking'.($i+1).'" type="text">                                            
                                          <label>Sellos </label><input class="sellos" numero="'.($i+1).'" type="number" name="sellos'.($i+1).'" min="0" max="3"> 
                                          <div id="sellos'.($i+1).'"></div>
                                    </div>';
                  }
                  $forma .= '</div>';

             $forma .= '<div style="display:block">';
            $forma .= '<label style="display:block"> Comentarios</label><textarea rows="9" name="comentarios"></textarea>';
            $forma .= '</div>';
            
            $forma .= '<br><input type="submit" class="btn btn-primary" >';
            $forma .= '<br><input type="reset" class="btn" class="btn btn-primary" >';
            $forma .= '</form>';

	}

	$resultados = array('forma' => $forma );

	echo json_encode($resultados);

?>