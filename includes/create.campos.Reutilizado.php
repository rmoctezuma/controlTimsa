<?php

require_once("../includes/generic.connection.php");
require_once("Objetos/ListaClientes.php");
require_once("Objetos/ListaAgencia.php");

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

            foreach ($rows as $fila) {
            	$forma .= '<h4>Agencia</h4>';
            	$forma .= '<label> Selecciona la Agencia<select>';

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

            	$forma .= '<label> Selecciona el Cliente<select id="Cliente">';

            	for ($i=0; $i < count($ListaClientes); $i++) { 
            		$cliente = $ListaClientes[$i];
            		$forma .= '<option value= "'. $cliente->getID() .'" >' . $cliente->getNombre() . '</option>';
            	}

            	$forma .= '</select><label>';


            	if($contenedores == "true"){
            		$forma .= '<h4>Tipo de Viaje</h4>';
            	}
            }

		}catch(PDOException $e){
          $forma = "Error";
        } 
	}

	$resultados = array('forma' => $forma );

	echo json_encode($resultados);

?>