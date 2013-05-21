<?php
	require_once("../includes/generic.connection.php");
	$mensaje = "";

	if(isset($_POST) && !empty($_POST)){
		$flete =  $_POST['value'];
		$status = $_POST['status'];
		$economico = $_POST['economico'];

		if($status == "Programado"){
			$mensaje = "<h4>No se pueden finalizar fletes programados</h4>";
		}
		else{

			try{

				$PDOmysql = consulta();

				$sql = 'UPDATE Flete 
				        set statusA = "Completo" 
				        where Flete.idFlete = :flete';
			
				$stmt = $PDOmysql->prepare($sql);
                 $stmt->bindParam(':flete', $flete);
                 $stmt->execute();

                 $respuesta =  $stmt->rowCount() ? true : false;

                 if($respuesta){

                 $sql = 'UPDATE Flete set  statusA = "Activo" 
						 where 
						 Flete.Economico = :economico
						 and 
						 Flete.statusA = "Programado"
			             order by Flete.Fecha
						 limit 1';

				$stmt = $PDOmysql->prepare($sql);
	            $stmt->bindParam(':economico', $economico);
	            $stmt->execute();

	            $respuesta =  $stmt->rowCount() ? true : false;

	            if(! $respuesta){
	                 $sql = 'UPDATE Economico set statusA = "Libre"
							 where
							 Flete.Economico = :economico';

					$stmt = $PDOmysql->prepare($sql);
		            $stmt->bindParam(':economico', $economico);
		            $stmt->execute();
	            }

	            $mensaje = "Flete Finalizado";
	        }
	        else{
	        	$mensaje = "No se pudo finalizar el Flete";
	        }

			}catch(PDOException $e){
				$mensaje = "No se puedo finalizar el Flete";
			}
		}
	}

	$resultados =  array('mensaje' => $mensaje );
	echo json_encode($resultados);

?>