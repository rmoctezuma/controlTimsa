<?php

include('../includes/generic.connection.php');
require_once('../includes/Objetos/Operador.php');

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
		
		default:
			# code...
			break;
	}

}

$array = array("contenido" => $resultado);

echo json_encode($array);

?>