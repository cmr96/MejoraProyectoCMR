<?php
include_once('db_configuration.php');
  $contenido = "";
  $connection = new mysqli($db_host, $db_user, $db_password, $db_name);
  if ($connection->connect_errno) {
      printf("Connection failed: %s\n", $mysqli->connect_error);
      exit();
  }
  $contenido = "";
  if ($result = $connection->query("SELECT COUNT(*) AS Pedidos, u.correo AS Usuario FROM pedido p, usuario u WHERE p.id_usuario = u.id_usuario GROUP BY u.id_usuario ORDER BY Pedidos ASC LIMIT 3;")) {
  while($obj = $result->fetch_object()) {
      if($contenido != ""){
        $contenido .= ', ';
      }

       $contenido.= '["'.$obj->Usuario.'", '.$obj->Pedidos.']';
  }


//Free the result. Avoid High Memory Usages
$result->close();
unset($obj);
unset($connection);

} //END OF THE IF CHECKING IF THE QUERY WAS RIGHT

?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar','corechart']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Cliente', 'Pedidos'],
          <?php
          echo $contenido;
           ?>
        ]);

        var options = {
          title: 'Pedidos por Cliente',
          width: 590,
          legend: { position: 'none' },
          chart: { title: 'Pedidos por cliente',
                   subtitle: 'Cantidad de pedidos por cada uno de los clientes' },
          bars: 'vertical', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'top', label: 'Clientes'} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
      };
    </script>
  </head>
  <body>
    <div id="top_x_div" style="width: 900px; height: 500px;margin-top:40px;"></div>
  </body>
</html>
