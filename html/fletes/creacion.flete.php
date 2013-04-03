<?php

try {
	 $mysqli = new PDO('mysql:host=www.timsalzc.com;dbname=timsalzc_ControlTimsa;charset=utf8', 'timsalzc_Raul', 'f203e21387');
				           

	} catch(PDOException $ex) {
		 echo "An Error occured!"; //user friendly message
		echo $ex->getMessage();
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Creacion de Fletes</title>

		<link href="../../css/bootstrap.min.css" rel="stylesheet" media="screen">
   		<link href="../../css/bootstrap-responsive.css" rel="stylesheet">

   		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	    <script src="../../js/bootstrap.min.js"></script>


	    <style>
		      body {
		        padding-top: 70px; /* 60px to make the container go all the way to the bottom of the topbar */
		      }
  		</style>

  		<script src="../../js/creacion.flete.action.js"></script>

	</head>

	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
		      <div class="navbar-inner">
		        <div class="container">
		          <div class="span2"></div>
		          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		          </button>
		          <a class="brand" href="../TIMSA.php">TIMSA </a>

		          <div class="nav-collapse collapse">
		            <ul class="nav">
		              <li class="">
		                <a href="../operadores.php">Operadores <i class="icon-user icon-white"></i> </a>
		              </li>
		              <li class="">
		                <a href="../economicos.php">Economicos <i class="icon-road icon-white"> </i> </a>
		              </li>
		              <li class="">
		                <a href="../clientes.php">Clientes <i class="icon-list icon-white"> </i> </a>
		              </li>
		              <li class="">
		                <a href="../socios.php">Socios <i class="icon-bookmark icon-white"> </i> </a>
		              </li>
		              <li class="active">
		                <a href="../cuotas.php">Cuotas <i class="icon-fire icon-white"> </i> </a>
		              </li>
		                 <li class="">
		                <a href="../fletes.php">Fletes <i class="icon-th-large icon-white"> </i> </a>
		              </li>
		            </ul>
		          </div>
		    </div>
		    </div>
		  </div>


		  <div class= "container">
		    <div class="page-header">
		    	<p>
		    	<h1 id="title">Flete MAERSK</h1> 
			    <div class="btn-group span2 offset10" id="seleccionAgencia">
				  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				    Agencia
				    <span class="caret"></span>
				  </a>
				  <ul class="dropdown-menu" id="listaAgencia" href="#">
				    <!-- dropdown menu links -->
				    <?php
				    			$sql = 'select idAgente,Nombre from Agencia where statusA = "Activo"';

						        foreach($mysqli->query($sql) as $fila){

						        	echo '<li><a href='.$fila['idAgente'] .'>'.$fila['Nombre'].'</a></li>';
						        }

				    ?>
				  </ul>
				</div>
			</p>
		    </div>

		    <div class="tabbable tabs-left">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#lA" data-toggle="tab">Cliente</a></li>
                <li><a href="#lB" data-toggle="tab">Socio</a></li>
                <li class="disabled" id="listaFlete"><a id="linkFlete" href="#lC" data-toggle="tab">Flete</a></li>
                <li class="disabled" id="listaContenedor"><a id="linkContendor" href="#lD" data-toggle="tab">Contenedor</a></li>
                <li><a href="#lE" data-toggle="tab">Comentarios</a></li>
              </ul>
              <div class="tab-content">             	
	                <div class="tab-pane active" id="lA">
	                	<div id="ClienteTab">
	                		<div  id='pagerR'>
	                		 <ul class="nav nav-list">
								  <li class="active"><a href="#"><i class="icon-home icon-white"></i> Home</a></li>
								  
							</ul>
		                	</div>
	                	<div id="Data">
	                	</div>
	                </div>	
                		<ul class="nav nav-pills nav-stacked" id="listaClientes" href="#">
	                			<?php
	                				$sql = 'select idCliente, Nombre from Cliente where statusA="Activo"';

	                				foreach ($mysqli-> query($sql) as $fila) {
	                					echo '<li ><a href='.$fila['idCliente'].'> '.$fila['Nombre'].' </a></li>';
	                				}
	                			?>
							</ul>
	                	</div>	                  
	                
	                <div class="tab-pane" id="lB">
			            
	                <div class="row-fluid">

	                	<select id="optionVal">
	                		<option value ="0"> Via Economico</option>
	                		<option value = "1"> Via Socio</option>
	                	</select>

	                	<div id="busquedaEconomico">
							<input type="text" class="input-medium search-query">
  							<button type="submit" class="btn">Search</button>
  						</div>


  					<div id="busquedaSocios">
	                <ul class="nav nav-pills nav-stacked span4" id="listaSocios" href="#" style="width:300px;height:290px;overflow:scroll;">
	                	<?php
	                		$sql = 'select idSocio, Nombre from Socio where statusA="Activo"';

	                		foreach ($mysqli-> query($sql) as $fila) {
	                				echo '<li ><a href='.$fila['idSocio'].'> '.$fila['Nombre'].' </a></li>';
	                				}
	                			?>
					  </ul> 
					 </div>

					   <div  id='EconomicoTab' class="span3">
				          </div>

				       </div>

				       <div id="OperadorTab">
				       		
			              </div>

	                
	                </div>

	                <div class="tab-pane" id="lC">
	                	<div id="Fletetab"> 
	                		<div id="botonGroupTrafico"  class="btn-group" data-toggle="buttons-radio">
	                			<button type="button" class="btn btn-large" data-toggle="button">Importacion</button>
	                			<button type="button" class="btn btn-large" data-toggle="button">Exportacion</button>
	                			<button type="button" class="btn btn-large" data-toggle="button">Reutilizado</button>
	                		</div>
	                		<br>
	                		<br>
	                		<div id="botonGroupViaje" class="btn-group" data-toggle="buttons-radio">
	                			<button type="button" class="btn btn-large" data-toggle="button">Sencillo</button>
	                			<button type="button" class="btn btn-large" data-toggle="button">Full</button>
	                		</div>
	                	</div>                  
	                </div>
	                <div class="tab-pane" id="lD">
	                	<div class="acordeon">
	                	</div>

	                </div>

	                <div class="tab-pane" id="lE">
	                	<h1> Comentarios del Viaje</h1>
	                	<textarea class="span10" rows="5" id="comentarios"></textarea>
	                </div>
	                </div>     
            </div>
            
            <hr>

		 <div id="results">

		 <table class="table table-bordered table-condensed span4">
		 	<tbody>
				 <tr>
				 	<td>Agencia</td>
				  	<td ><span id="Agencia" class="label label-inverse"> MAERSK </span> </td>
				</tr>
				  <td> Cliente</td>
				  <td ><span id="Cliente" class="label label-inverse"> Sin asignar </span></td>
				 </tr>
				  <tr>
				  	<td>Sucursal</td>
				  	<td ><span id="Sucursal" class="label label-inverse"> Sin asignar </span></td>
				 </tr>
				 <tr>
				 	<td>Socio</td>
				  <td > <span id="Socio" class="label label-inverse"> Sin asignar </span></td>
				 </tr>
				 <tr>
				 	<td>Operador</td>
				  <td ><span id="Operador" class="label label-inverse"> Sin asignar </span></td>
				 </tr>
				 <tr>
				 	<td>Economico</td>
				  <td ><span id="Economico" class="label label-inverse"> Sin asignar </span></td>
				 </tr>
				 <tr><td>Cuota</td>
				  <td ><span id="Cuota" class="label label-inverse"> Sin especificar </span></td>
				 </tr>
				 <tr>
				 	<td>Viaje</td>
				  <td ><span id="Trafico" class="label label-inverse"> Sin especificar </span>
				   <span id="Viaje" class="label label-inverse"> Sin especificar </span>
				</td>
				 </tr>
				 <tr><td>Tarifa</td>
				  <td ><span id="Tarifa" class="label label-inverse"> Sin especificar </span></td>
				 </tr>
			  </tbody>
			</table>

			<table class="table table-bordered table-condensed span4">
				<tbody>
					<tr id="Contenedor">
						<td> Contenedor </td>
					</tr>
					<tr id="WorkOrder">
						<td> WorkOrder </td>
					</tr>
					<tr id="Booking">
						<td> Booking</td>
					</tr>
					<tr id="Tipo">
						<td> Tipo Contenedor </td>
					</tr>
				</tbody>
			</table>

			<table class="table table-bordered table-condensed span4">
				<tbody id="tablaContenedor">
				</tbody>
			</table>

		<div id="createFlete" class="span2">
		 	<button disabled="disabled" class="btn btn-primary btn-large disabled">Crear</button>
		 </div>

		 </div>




		 </div>

	</body>

</html>