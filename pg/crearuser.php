<?PHP
include_once("db_configuration.php");
$connection = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($result = $connection->query("SELECT * FROM usuario;")){

session_start();

if(!isset($_SESSION["tema"])){
    $_SESSION["tema"]=array("img/logo.jpg","img/boton.jpg","dropbtn","dropdown-content","dropdown","desp","ul","encabezado","medio","final","get","desp21","desp22","desp23","desp24","desp25","desp26","dialog","#0C5484","fotodos","boton");
  }
?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hardbyte S.L</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="hardbytecss.css"/> <!-- CAMBIA -->
    <link href='https://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Candal' rel='stylesheet' type='text/css'>
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
    .desp21 a {
      color: white;
    }
    .desp212 a {
      color: white;
    }
    .desp213 a {
      color: white;
    }
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
			<img id="fotouno" src="img/logo.jpg"> <!-- CAMBIA -->
			<div class="<?php echo $_SESSION['tema'][5]; ?>">
				<div class="desp3">
					<div class="<?php echo $_SESSION['tema'][11]; ?>" style="background-color:<?php echo $_SESSION['tema'][18]; ?>;color:#ffffff;"> <!-- CAMBIA -->
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

      <!-- Inicio del Carrito -->


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
                      echo "<a href='descripcion.php?id_producto=$obj->id_producto'>";
                      ?>
                      <img style="width:50px;height:50px;" id="fotousuario" src="data:image/jpg;base64,<?php echo base64_encode($obj->foto);?>" >
                      <?php
                      echo "<br>";
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

    <style>
    #medio td {
      color: #FFFFFF;
      padding-left: 20px;
      padding-top: 5px;
    }
    #medio h1 {
      color: #FFFFFF;
      padding-top: 20px;
      padding-left: 20px;
    }
    #medio {
      margin-top: -22px
    }
    #final {
      margin-top: -10px;
    }
    #medio2 td {
      color: #FFFFFF;
      padding-left: 20px;
      padding-top: 5px;
    }
    #medio2 h1 {
      color: #FFFFFF;
      padding-top: 20px;
      padding-left: 20px;
    }
    #medio2 {
      margin-top: -22px
    }
    #final2 {
      margin-top: -10px;
    }
    #medio3 td {
      color: #FFFFFF;
      padding-left: 20px;
      padding-top: 5px;
    }
    #medio3 h1 {
      color: #FFFFFF;
      padding-top: 20px;
      padding-left: 20px;
    }
    #medio3 {
      margin-top: -22px
    }
    #final3 {
      margin-top: -10px;
    }
    .container-page {
      color: white;
    }
    .form-group {
      color: white;
    }
    </style>


      <?php

      printf("<h1>Crear Usuario</h1>");
      if (!isset($_POST["nombre"])) :
      $connection = new mysqli($db_host, $db_user, $db_password, $db_name);
      if ($connection->connect_errno) {
          printf("Connection failed: %s\n", $mysqli->connect_error);
          exit();


      }

        ?>
      <form action="" method="post" class="id_usuario">
        <?php
        echo "<div class='container-page'>";
        ?>



              <?php
               // elegir usuario:
               $result=$connection->query("select MAX(id_usuario) as id from usuario");
               while ($fila=$result->fetch_object()) {
               $res=$fila->id;
               $res=$res+1;

                }
               ?>
          </div>

              <div class='form-group col-lg-6'>
                Nombre:
                <input class='form-control' type=text name='nombre' required>
              </div>
              <div class='form-group col-lg-6'>
                Apellidos:
                <input class='form-control' type=text name='apellidos' required>
              </div>
              <div class='form-group col-lg-6'>
                Password:
                <input class='form-control' type=password name='password' required>
              </div>
              <div class='form-group col-lg-6'>
                Correo:
                <input class='form-control' type=email name='correo' required>
              </div>
              <div class='form-group col-lg-6'>
                Telefono:
                <input class='form-control' type=text name='telefono'>
              </div>
              <div class='form-group col-lg-6'>
              Direccion:
              <input class='form-control' type=text name='direccion'required>
              </div>
              <?php
              echo "<div class='form-group col-lg-6'><input class='ev' type='hidden'></div>";
              echo "<div class='form-group col-lg-6'><input class='ev' type='hidden'></div>";
              ?>
              <div class='form-group col-lg-6'>
              <input class='form-control' type=submit value="Crear" id="enviar">
              </div>
              <?php
              echo "</div>";
              ?>
            </form>


        <?php  else: ?>

        <?php
        $connection = new mysqli($db_host, $db_user, $db_password, $db_name);
        $nombre=$_POST["nombre"];
        $apellidos=$_POST["apellidos"];
        $password=$_POST["password"];
        $correo=$_POST["correo"];
        $telefono=$_POST["telefono"];
        $direccion=$_POST["direccion"];

        $result=$connection->query("select MAX(id_usuario) as id from usuario");
        while ($fila=$result->fetch_object()) {
        $res=$fila->id;
        $res=$res+1;

        $insert="INSERT INTO usuario VALUES ('$res', 'user', '$nombre', '$apellidos', MD5('$password'), '$correo', '$telefono', '$direccion')";
                        }
        $connection->query( $insert );

      ?>


        <h4 style="margin-left:20px;color:black">USUARIO CREADO CON EXITO<h4>

        <?php endif ?>

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
  <?php
  }else{
     header('Location: instalador.php');
  }
  ?>
