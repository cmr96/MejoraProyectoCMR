<?php
  session_start();
?>


<?php
 include_once("./db_configuration.php");
?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hardbyte S.L</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="hardbytecss.css"/> <!-- CAMBIA -->
    <link href='https://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Candal' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Alegreya+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body>
	<div id="main">
	  <!-- Inicio LOGIN-REGISTRO -->

	  <script type="text/javascript">
	  $(document).ready(function() {

	  $('#dialog_link').click( function() {
		  $('#dialog').dialog();
	  });

	});
	  </script>

	  <style>
	  #enviar {float:right;}
	  </style>



	<div id="dialog" title="Identificate" style="display:none">
	  <form action="home.php" method="post" class="login">
	  <table border="0">
		<tr>
		  <td id="son">E-mail:  </td>
		  <td><input type="text" name="usu" maxlength="40" size="10" required></td>
		</tr>
		<tr>
		  <td id="son">Contraseña:  </td>
		  <td><input type="password" name="pass"  maxlength="40" size="10" required></td>
		</tr>
		<tr>
		  <td colspan="2"><input type="submit" value="Entrar" id="enviar"></td>
		</tr>
	  </table>
	  </form>
	</div>

	<?php

		if (isset($_POST["usu"])) {

		  $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

		  if ($connection->connect_errno) {
			  printf("Connection failed: %s\n", $connection->connect_error);
			  exit();
		  }

		  $query = $connection->prepare("SELECT * FROM usuario
			WHERE correo=? AND password=md5(?)");

		  $query->bind_param("ss",$_POST["usu"],$_POST["pass"]);

		  if ($query->execute()) {

			$query->store_result();

			  if ($query->num_rows===0) {
				header("Location: home.php");
			  } else {

				$_SESSION["usu"]=$_POST["usu"];
				$_SESSION["language"]="es";

				$_SESSION['permiso'] = [];

				$result=$connection->query("
				SELECT
        permiso.tienda AS tienda,
				permiso.usuarios AS usuarios,
				permiso.productos AS productos,
        permiso.pedidos AS pedidos
				FROM usuario, permiso
				WHERE
				usuario.correo = '".$_SESSION['usu']."'
				AND
				usuario.id_permiso = permiso.id_permiso
				");
				$permisos=$result->fetch_assoc();

				foreach($permisos as $clave => $valor){
					$permisos[$clave] = explode(":", $valor);
				}
				$_SESSION['permisos'] = $permisos;

				$query->close();

				//header("Location: home.php");
			  }
		  } else {
			echo "Wrong Query";
			var_dump($consulta);
		  }
	  }
	?>

	<!-- Fin LOGIN-REGISTRO -->

		<div id="<?php echo $_SESSION['tema'][7]; ?>">
			<img id="fotouno" src="<?php echo $_SESSION['tema'][0]; ?>"> <!-- CAMBIA -->
			<div class="<?php echo $_SESSION['tema'][5]; ?>">
				<div class="desp3">
					<div class="<?php echo $_SESSION['tema'][11]; ?>" style="<?php echo $_SESSION['tema'][18]; ?>"> <!-- CAMBIA -->
					<p>
						<a href="home.php"> INICIO </a> <!-- CAMBIA -->
					</p>
				</div>
						<div class="<?php echo $_SESSION['tema'][12]; ?>" style="<?php echo $_SESSION['tema'][18]; ?>">
							<p><a href="tienda.php"> TIENDA </a> <!-- CAMBIA -->
							</p>
						</div>
					<?PHP
						if(isset($_SESSION['permisos']) && $_SESSION['permisos']['productos'][0]){
					?>
						<div class="<?php echo $_SESSION['tema'][13]; ?>" class="hide1" style="<?php echo $_SESSION['tema'][18]; ?>">
							<p><a href="producto.php"> PRODUCTOS </a> <!-- CAMBIA -->
							</p>
						</div>
					<?PHP
						}
						if(isset($_SESSION['permisos']) && $_SESSION['permisos']['usuarios'][0]){
					?>
						<div class="<?php echo $_SESSION['tema'][14]; ?>" class="hide2" style="<?php echo $_SESSION['tema'][18]; ?>">
							<p><a href="usuario.php"> USUARIOS </a> <!-- CAMBIA -->
							</p>
						</div>
            <?PHP
  						}
            if(isset($_SESSION['permisos']) && $_SESSION['permisos']['pedidos'][0]){
          ?>
            <div class="<?php echo $_SESSION['tema'][15]; ?>" class="hide3" style="<?php echo $_SESSION['tema'][18]; ?>">
              <p><a href="gestion_pedido.php"> PEDIDOS </a> <!-- CAMBIA -->
              </p>
            </div>
            <?PHP
              }
              if(isset($_SESSION['permisos']) && $_SESSION['permisos']['tienda'][0]){
            ?>
              <div class="<?php echo $_SESSION['tema'][16]; ?>" style="<?php echo $_SESSION['tema'][18]; ?>">
                <p><a href="panel.php"> PANEL </a> <!-- CAMBIA -->
                </p>
              </div>
              <?PHP
                }
              ?>
          </div>
  				  </div>
			<div id="<?php echo $_SESSION['tema'][6]; ?>">
				<ul>
				  <!-- Inicio Conect/Desconect -->
				  <?php

					  if (!isset($_SESSION["usu"])) {
						echo "<li id='dialog_link'>Conectarse</li>";
						}

				  ?>
				  <?php

					  if (isset($_SESSION["usu"])) {
						echo "<li><a href='cerrarsesion.php'>Desconectarse</a></li>";
						}

				  ?>

          <?php

              if (!isset($_SESSION["usu"])) {
                echo "<li><a href='crearuser.php'>Crear Cuenta</a></li>";
                }

          ?>

				  <!-- Fin Conect/Desconect -->
				</ul>
			</div>

			<!-- Inicio Carrito -->

      <div class="<?php echo $_SESSION['tema'][4]; ?>">
			  <button class="<?php echo $_SESSION['tema'][2]; ?>"><i class="fa fa-shopping-cart fa-2x fa-lg"></i></button>
			  <div class="<?php echo $_SESSION['tema'][3]; ?>">
			<?PHP
      if(isset($_SESSION['carrito'])){

      	$connection = new mysqli($db_host, $db_user, $db_password, $db_name);
        foreach($_SESSION['carrito'] as $id => $cantidad){
                    if($cantidad > 0){

              if ($result = $connection->query("SELECT * FROM producto WHERE id_producto='$id'")) {
                  while($obj = $result->fetch_object()) {
                      echo "<a href='descripcion.php?id_producto=$obj->id_producto'><img src='img/".$obj->foto."'><br>";
                      echo substr($obj->nombre, 0, 12)."...<br>";
                      echo "Cantidad: ".$cantidad."</a><br>";
                  }
                }
        }
      }
    }
			?>
        <a href="pedido.php"><p>Ver Carrito</p></a>
			  </div>
			</div>

			<!-- Fin Carrito -->

		</div>
		<div id="<?php echo $_SESSION['tema'][8]; ?>">


      <div class="ax">
      <h2>Asistencia 24h</h2>
      <p>Puedes contactar enviando un correo a uno de los siguientes e-mails:</p>
      <ul>
        <li>carlos1m2r3@hotmail.com</li>
        <li>neothegod1996@gmail.com</li>
      </ul>
      </div>
      <style>
      .ax {
        padding-top: 100px;
        margin-left: 200px;
        font-family: 'Alegreya Sans', sans-serif;
        font-size: 20px;
        color: white;
      }

      </style>

</div>

<div id="<?php echo $_SESSION['tema'][9]; ?>">
  <div id="f">
  </br>
    <p style="text-decoration: none;"><a href="conocenos.php">Conocenos</a></p>
    <p style="text-decoration: none;"><a href="asistencia.php">Asistencia 24h</a></p>
  </div>
</div>
</div>
</body>
</html>
