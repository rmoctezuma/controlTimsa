<?php

require_once("../includes/generic.connection.php");
require_once("Objetos/ListaClientes.php");
require_once("Objetos/ListaAgencia.php");
require_once("Objetos/Flete.php");

	$forma = "";

	if(isset($_POST) && !empty($_POST)){
		$idFlete = $_POST['flete'];
		$contenedores = $_POST['contenedores'];

		try{

			$PDOmysql = consulta();

			$sql = 'SELECT * FROM Flete  WHERE Flete.idFlete = :flete';

			$stmt = $PDOmysql->prepare($sql);
            $stmt->bindParam(':flete', $idFlete);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $forma .= '<form id="formaReutilizado"  method="POST" action="../includes/FleteReutilizado.php">';
            $forma .= '<div id="DatosFletePadre">';
            $forma .= '<h4> Flete Raiz </h4>';
            $forma .= '<input name="fletePadre" type="text" value="'.$idFlete.'">';

            $FletePadre = new Flete;
            $FletePadre->getFleteFromID($idFlete);

            $operador = $FletePadre->get_Operador();

            $forma.= '<h4>Operador</h4>';
            $forma.= '<input type="text" value="'. $operador->get_nombre().  $operador->get_apellidop(). $operador->get_apellidom().'">';
            $forma.= '<h4> Economico </h4>';
            $forma.= '<input type="text" value="'. $FletePadre->get_Economico()->get_id() .'">';

            $forma.='</div>';
            foreach ($rows as $fila) {
            	$forma .= '<h4>Agencia</h4>';
            	$forma .= '<label> Selecciona la Agencia<select id="Agencia" name="Agencia">';

            	$agencias 		 = new ListaAgencia;
            	$ListaAgencias   = $agencias->getAgencias();

            	for ($i=0; $i < count($ListaAgencias); $i++) { 
            		$agencia = $ListaAgencias[$i];
            		$forma .= '<option value= "'. $agencia->getAgencia() .'" >' . $agencia->getNombre() . '</option>';
            	}
            	$forma .= '</select></label>';


            	$forma .= '<h4>Cliente</h4>';

            	$clientes 		 = new ListaClientes;
            	$ListaClientes   = $clientes->getLista();

            	$forma .= '<label id ="Cliente"> Selecciona el Cliente<select id="Cliente" name="Cliente">';

            	for ($i=0; $i < count($ListaClientes); $i++) {
            		$cliente = $ListaClientes[$i];
            		$forma .= '<option value= "'. $cliente->getID() .'" >' . $cliente->getNombre() . '</option>';
            	}

            	$forma .= '</select></label>';

            	if($contenedores == "true"){
            		$forma .= '<h4>Tipo de Viaje</h4>';
                        $forma .= '<label> &nbsp<input type="radio" name="tipoViaje" value="Sencillo" >  Sencillo  </label>';
                        $forma .= '<label> &nbsp<input type="radio" name="tipoViaje" value="Full" >  Full  </label>';
                        $forma .='<br>';
                        $forma .= '<div id="nuevosContenedores"></div>';
            	}

                  $forma .= '<label> Comentarios</label><textarea name="comentarios"></textarea>';
            }
            $forma .= '<br><br><input type="submit" class="btn btn-primary" >';
            $forma .= '</form>';

		}catch(PDOException $e){
          $forma = "Error";
        } 
	}

	$resultados = array('forma' => $forma );

	echo json_encode($resultados);

?>