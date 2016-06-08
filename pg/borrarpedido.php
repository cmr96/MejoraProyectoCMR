<?php
session_start();
if(isset($_SESSION['permisos']) && $_SESSION['permisos']['pedidos'][0]){
?>
<?php
 include_once("./db_configuration.php");
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
  </head>
  <body>


<?php
$connection = new mysqli($db_host, $db_user, $db_password, $db_name);
$link=$_GET["id_pedido"];

$delete1="DELETE FROM entrada_pedido WHERE id_pedido='$link'";
$delete2="DELETE FROM pedido WHERE id_pedido='$link'";

$connection->query( $delete1 );
$connection->query( $delete2 );

header("refresh:0; url=gestion_pedido.php");
?>

</body>
</html>

<?php
}
else{
  header("Location:home.php");
}
  ?>
