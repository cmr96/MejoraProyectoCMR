<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="hardbytecss.css">
  </head>
  <body>
    <div style="width:1000px;margin: 0 auto;margin-top:40px;">
      <div>
          <h1 style="margin-left:20px;margin-bottom:20px";>Hardbyte: Instalador Web</h1>
    <div class='form-group col-lg-5'>
            <form action="" method="post">

    					<div class="form-group">
                <input type="text" name="formusu" class="form-control input-lg " placeholder="Usuario" required>		</div>
    				</div>
    				<div class="form-group col-lg-5">
    					<div class="form-group">
                    <input type="password" name="formpass" class="form-control input-lg" placeholder="Contraseña">
    					</div>
    				</div>
            <div class="form-group col-lg-5">
    					<div class="form-group">
                  <input type="text" name="formhost" class="form-control input-lg" placeholder="Host de la BD" required>
                </div>
    				</div>

            <div class="form-group col-lg-5">
              <div class="form-group">
                  <input type="text" name="formbd" class="form-control input-lg" placeholder="Nombre de la BD" required>
                </div>
            </div>
            <div class="form-group col-lg-5">
              <div class="form-group">
                <p style="font-size:20px;margin-top:10px;">Contenido de la Base de Datos:</p>
              </div>
            </div>
            <div class="form-group col-lg-5">
              <div class="form-group">
            <select class="form-control input-lg" name="contenido" required>
              <option class="form-control input-lg" value="completa">Base de datos y contenido</option>
              <option class="form-control input-lg" value="no_completa">Solo Base de datos</option>
            </select>
              </div>
            </div>
            <div class="form-group col-lg-5">
            <div class="form-group">
            <input type="submit" value="Instalar" class="btn btn-primary pull-left">
            </div>
            </div>
            </div>
          </div>
          </div>

        </form>
        <?php
          if(isset($_POST["formusu"])){
              $contenido=$_POST["contenido"];
              $usuario=$_POST["formusu"];
              $password=$_POST["formpass"];
              $bd=$_POST["formbd"];
              $host=$_POST["formhost"];
              $connection = new mysqli($host, $usuario, $password, $bd);
              if ($connection->connect_errno) {
                   printf("Connection failed: %s\n", $connection->connect_error);
                   exit();
              }else{
                if($contenido == 'completa'){
                  // Name of the file
                  $filename = 'completa.sql';
                  // MySQL host
                  $mysql_host = $host;
                  // MySQL username
                  $mysql_username = $usuario;
                  // MySQL password
                  $mysql_password = $password;
                  // Database name
                  $mysql_database = $bd;

                  // Connect to MySQL server

                  // Temporary variable, used to store current query
                  $templine = '';
                  // Read in entire file
                  $lines = file($filename);
                  // Loop through each line
                  foreach ($lines as $line)
                  {
                  // Skip it if it's a comment
                  if (substr($line, 0, 2) == '--' || $line == '')
                      continue;

                  // Add this line to the current segment
                  $templine .= $line;
                  // If it has a semicolon at the end, it's the end of the query
                  if (substr(trim($line), -1, 1) == ';')
                  {
                      // Perform the query
                      $connection->query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                      // Reset temp variable to empty
                      $templine = '';
                  }
                  }
                   echo "Tables imported successfully";
                }else{
                  // Name of the file
                  $filename = 'solobd.sql';
                  // MySQL host
                  $mysql_host = $host;
                  // MySQL username
                  $mysql_username = $usuario;
                  // MySQL password
                  $mysql_password = $password;
                  // Database name
                  $mysql_database = $bd;

                  // Connect to MySQL server

                  // Temporary variable, used to store current query
                  $templine = '';
                  // Read in entire file
                  $lines = file($filename);
                  // Loop through each line
                  foreach ($lines as $line)
                  {
                  // Skip it if it's a comment
                  if (substr($line, 0, 2) == '--' || $line == '')
                      continue;

                  // Add this line to the current segment
                  $templine .= $line;
                  // If it has a semicolon at the end, it's the end of the query
                  if (substr(trim($line), -1, 1) == ';')
                  {
                      // Perform the query
                      $connection->query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                      // Reset temp variable to empty
                      $templine = '';
                  }
                  }
                   echo "Tables imported successfully";
                }
                $file = fopen("db_var.php", "a");
                fwrite($file, "<?php"."\n");
                fwrite($file, "$"."usuario="."'".$usuario."';"."\n");
                fwrite($file, "$"."password="."'".$password."';"."\n");
                fwrite($file, "$"."bd="."'".$bd."';"."\n");
                fwrite($file, "$"."host="."'".$host."';"."\n");
                fwrite($file, "?>"."\n");
                fclose($file);
                // unlink('instalador.php');
                // unlink('db_sql.php');
                // unlink('db_sql_completa.php');
                // header('Location:home.php');
              }
          }
        ?>
    </div>
  </body>
  </html>
