<?php
$contenido = "";
$contenidoSellosResult = "";


if(isset($_POST) && !empty($_POST)){
		$contador = 0;
		$tipo = $_POST['tipo'];
		$value =  $_POST['value'];
		$numero = 1 + $tipo;
		$rango = $_POST['rango'];
		$option = $_POST['option'];

		while ($contador < $value) {
			$contador += 1;

			$contenido.= '<input type="text" name="sello'.($numero).'" class="selloInput" placeholder="Sello '.$contador.'">';
			$numero+= 2;
		}

		$contador = 1;
		$nuevoContador = 1;

		while ($contador < ($option * 2)) {
				$contenidoSellosResult.= '<tr id="Sello'.($contador).'">';
				$contenidoSellosResult.= '<td>Sello '.abs($nuevoContador).'</td>';
				if($rango>1){
					$contenidoSellosResult.='<td><span id="sello'.($contador + 1).'" class="label label-inverse"> Sin especificar </span></td>';
				}	
				$contenidoSellosResult.='<td><span id="sello'.($contador ).'" class="label label-inverse"> Sin especificar </span></td>';	
				$contenidoSellosResult.='</tr>';
				$contador+=2;
				$nuevoContador+=1;
			}	

				
}

$resultado = array( "contenido" => $contenido,
					"contenidoResult" => $contenidoSellosResult);

echo json_encode($resultado);



?>