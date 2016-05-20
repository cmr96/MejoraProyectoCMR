<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <link rel="stylesheet" href="hardbytecss.css">
  </head>
  <body>
        			<h4>Instalador Web</h4>
    <div class='form-group col-lg-6'>
            <form action="" method="post">

    					<div class="form-group">
                <input type="text" name="formusu" class="form-control input-lg " placeholder="Usuario">		</div>
    				</div>
    				<div class="form-group col-lg-6">
    					<div class="form-group">
                    <input type="password" name="formpass" class="form-control input-lg" placeholder="Contraseña">
    					</div>
    				</div>
            <div class="form-group col-lg-6">
    					<div class="form-group">
                  <input type="text" name="formhost" class="form-control input-lg" placeholder="Host de la BD">  					</div>
    				</div>

            <div class="form-group col-lg-6">
              <div class="form-group">
                  <input type="text" name="formbd" class="form-control input-lg" placeholder="Nombre de la BD">  					</div>
            </div>

            <input type="submit" value="Crear Base de Datos" class="btn btn-primary pull-left">

    			</div>

        </div>
      </div>




        </form>
        <?php
          if(isset($_POST["formusu"])){
              $usuario=$_POST["formusu"];
              $password=$_POST["formpass"];
              $bd=$_POST["formbd"];
              $host=$_POST["formhost"];
              $connection = new mysqli($host, $usuario, $password, $bd);
              if ($connection->connect_errno) {
                   printf("Connection failed: %s\n", $connection->connect_error);
                   exit();
              }else{
                include("db_sql.php");
                $file = fopen("configuration_instalacion.php", "a");
                fwrite($file, "<?php"."\n");
                fwrite($file, "$"."usuario="."'".$usuario."';"."\n");
                fwrite($file, "$"."password="."'".$password."';"."\n");
                fwrite($file, "$"."bd="."'".$bd."';"."\n");
                fwrite($file, "$"."host="."'".$host."';"."\n");
                fwrite($file, "?>"."\n");
                fclose($file);
                unlink('instalacion.php');
                 unlink('db_sql.php');
                 header('Location:home.php');
              }
          }
        ?>
    </div>
