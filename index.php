<!DOCTYPE html>
<html>
<head>
	<title>Entrada </title>
	<link href="Timsa/css/bootstrap.css" rel="stylesheet">
	<meta charset="utf-8">

	<style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

      body { background:url('paper.gif'); }
      </style>


</head>

<body>

<div class = "container">
 
	<form class="form-signin" action="procesarSesion.php" method="POST">
    <?php
      if(isset($_GET['resultado'])){
        echo '<div class="alert span2">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong>Login Incorrecto</strong> .
              </div>';
      }
    ?>
        <h2 class="form-signin-heading">Entrada</h2>
       
        <input required type="text" class="input-block-level" placeholder="Email" name="username">
        <input required type="password" class="input-block-level" placeholder="Contraseña" name="pass">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Recordarme
        </label>

        <button class="btn btn-large btn-primary" type="submit" >Entrar</button>

      </form>
</div>

	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="Timsa/js/bootstrap.js"></script>
    <!--
    <script src="js/bootstrap-alert.js"></script>
    <script src=".js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src=".js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src=".js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
  -->
</body>
</html>