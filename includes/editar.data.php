<?php

include('../includes/generic.connection.php');
require_once('../includes/Objetos/Operador.php');
require_once('../includes/Objetos/Economico.php');
require_once('../includes/Objetos/Socio.php');

$resultado = "";

if(isset($_POST) && !empty($_POST)){
	switch ($_POST['tipo']) {
		case 'Operador':
			if(isset($_POST['operador']) && !empty($_POST['operador'])){
				$operador = new Operador;
				$operador->getOperadorFromID($_POST['operador']);

				$resultado .= '<form id="editarOperadorForm" method="POST" enctype="multipart/form-data" action="../includes/update.data.php">
								  <input type="hidden" value="operador" name="tipo">
								  <br>
								  <br>
								  <h1>Editar Operador</h1>	  

								  <label> Numero de Control </label>
								  <input type="text" name="controlOperador" id="actual" readonly value="'.$operador->get_id().'"><br>
								  
							      <label> Nombre </label>
							      <input  type="text" name="NombreOperador" required value="'.$operador->get_nombre().'"> <br>
							      <label> Apellido Paterno </label>
							      <input  type="text" name="ApellidoOperador" required value="'.$operador->get_apellidop().'"> <br>
							      <label> Apellido Materno </label>
							      <input  type="text" name="ApellidoMOperador" required value="'.$operador->get_apellidom().'"> <br>
							      <label> Telefono </label>

							      <input  type="text" name="telefono" required value="'.$operador->get_telefono().'"><br>
							      <label> R. C. </label>
							      <input  type="text" name="rc" value="'.$operador->get_RC() .'"> <br>
							      <label> CURP </label>
							      <input  type="text" name="curp" required value="'.$operador->get_curp().'"> <br>
							      <label> Imagen Actual del operador. Para cambiar seleccione otra imagen. </label>
							      <img id="imagenActual" src="'.$operador->get_imagen().'">
							      <input type="file" name="archivo" id="archivo" /><br>
							      <input type="submit" class="btn btn-primary" name="boton" value="Subir" id="submit"/>
							      <button class="btn cancelarEdicion" type="reset"> Cancelar</button>
							    </form>';
			}
			else{
				$resultado .= '<h4>No se puede Editar :(</h4>
							 <button class="btn cancelarEdicion" type="reset"> Volver</button>';
			}
			break;
		case 'Economico':
		if(isset($_POST['economico']) && !empty($_POST['economico'])){
			$economico = new Economico;
			$economico->createEconomicoFromID($_POST['economico']);
			$socio = new Socio;
			$socio->createSocioFromID( $economico->get_Socio() );
			

			$resultado .= '
							<form method="POST" action="../includes/update.data.php" enctype="multipart/form-data" id="editarEconomicoForm">
						      <h1>Editar Economico</h1>
						      <input type="hidden" value="economico" name="tipo">
						      <label> <b>Numero de Economico</b> </label> <input readonly type="text" name="numero" value="'.$economico->get_id().'"> <br>
						      <label> <b>Placas</b> </label> <input required type="text" name="Placas" placeholder="Numero de Placas" value="'.$economico->get_placas().'"> <br>
						        <label><b> Socio  </b> </label> 
						        <input type="text" readonly value="'. $socio->get_Nombre() . '">

						      <label> <b>Serie</b> </label> <input type="text" class="required" name="numeroSerie" placeholder="Numero de Serie" value="'.$economico->get_serie().'"> <br>
						      <label> <b>Modelo</b> </label> <select name="modelo" id="Modelo">';

		$resultado .=        consultaAnio( $economico->get_modelo() );

		$resultado .=		'</select> <br>
						      <label> <b>Transponder</b> </label> <input type="text" name="transponder" placeholder="Numero de Transponder" value="'.$economico->get_transponder().'"> <br>
						      <label> <b> Marca </b> </label> 
						      <select name="marca">';

						          $sql = 'SELECT distinct Nombre, idMarca from Marca';

						          	$PDOmysql = consulta();

						            $stmt = $PDOmysql->query($sql);
						            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

						            foreach ($rows as $fila) {
						            	if($fila['Nombre'] == $economico->get_marca()){
						            		$resultado .= '<option  value="'. $fila['idMarca'].'" selected>'.$fila['Nombre'].' </option>';
						            	}
						            	else{
						            		$resultado .= '<option value="'. $fila['idMarca'].'">'.$fila['Nombre'].' </option>';
						            	}
						            }

						        $resultado .= '
						       </select>
						      <label><b> Tipo de Vehiculo </b> </label> 
						      <select name="tipoVehiculo">';
						        
						            $sql = 'SELECT distinct Nombre, idTipoVehiculo from TipoVehiculo';

						            $stmt = $PDOmysql->query($sql);
						            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
						            $economico->set_tipoVehiculo() ;

						            foreach ($rows as $fila) {
		
						            		$resultado .=  '<option value="'. $fila['idTipoVehiculo'].'">'.$fila['Nombre'].' </option>';
						            	
						               		
						            }
						      $resultado .= ' 
						      </select>
						      
						      <br>
						      <br>
						      <input type="submit" name="submit" class="btn btn-primary" name="boton"  id="submit" value="Subir"/> 
						      <br>
						      <button class="btn" type="reset" id="cancelarEdicion"> Cancelar</button>
						    </form>';
						}
						else{
							$resultado .= '<h4>No se puede Editar :(</h4>
										 <button class="btn" id="cancelarEdicion" type="reset"> Volver</button>';
						}
			break;
		
		default:
			# code...
			break;
	}

}

$array = array("contenido" => $resultado);

echo json_encode($array);

function consultaAnio($fechas){
  $fecha = "";
   for($i=date('o') + 1; $i>=1910; $i--){
            if ($i == $fechas)
                $fecha.= '<option value="'.$i.'" selected>'.$i.'</option>';
            else
               $fecha.='<option value="'.$i.'">'.$i.'</option>';
        }
        return $fecha;
}

?>